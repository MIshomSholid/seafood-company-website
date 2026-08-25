<?php

require_once __DIR__ . '/../../config/database.php';

class Inquiry
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Generate unique reference number formatted: SKM-YYYYMMDD-XXXX
     */
    public function generateReferenceNumber(): string
    {
        $datePrefix = date('Ymd');
        $prefix = "SKM-{$datePrefix}-";

        $stmt = $this->db->prepare("
            SELECT reference_number FROM inquiries
            WHERE reference_number LIKE :prefix
            ORDER BY id DESC LIMIT 1
        ");
        $stmt->execute(['prefix' => "{$prefix}%"]);
        $lastRef = $stmt->fetchColumn();

        if ($lastRef && preg_match('/-(\d{4})$/', $lastRef, $matches)) {
            $nextSeq = (int) $matches[1] + 1;
        } else {
            $nextSeq = 1;
        }

        return sprintf("%s%04d", $prefix, $nextSeq);
    }

    public function create(array $data): ?array
    {
        $refNumber = $this->generateReferenceNumber();

        $userId = !empty($data['user_id']) ? (int) $data['user_id'] : null;
        $productId = !empty($data['product_id']) ? (int) $data['product_id'] : null;

        $stmt = $this->db->prepare("
            INSERT INTO inquiries (
                user_id, reference_number, name, company, email, phone,
                type, product_id, quantity, message, status,
                priority, admin_note, created_at, updated_at
            ) VALUES (
                :user_id, :reference_number, :name, :company, :email, :phone,
                :type, :product_id, :quantity, :message, :status,
                :priority, :admin_note, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
            )
        ");

        $status = $data['status'] ?? 'new';
        $priority = $data['priority'] ?? 'normal';
        $type = $data['type'] ?? 'quotation';
        $company = !empty($data['company']) ? trim($data['company']) : null;
        $email = !empty($data['email']) ? trim($data['email']) : null;
        $adminNote = !empty($data['admin_note']) ? trim($data['admin_note']) : null;

        $success = $stmt->execute([
            'user_id' => $userId,
            'reference_number' => $refNumber,
            'name' => trim($data['name']),
            'company' => $company,
            'email' => $email,
            'phone' => trim($data['phone']),
            'type' => $type,
            'product_id' => $productId,
            'quantity' => !empty($data['quantity']) ? trim($data['quantity']) : null,
            'message' => trim($data['message'] ?? 'Permintaan penawaran harga'),
            'status' => $status,
            'priority' => $priority,
            'admin_note' => $adminNote,
        ]);

        if ($success) {
            $id = (int) $this->db->lastInsertId();
            return $this->getById($id);
        }

        return null;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT i.*, 
                   p.name AS product_name, p.stock AS product_stock, p.image AS product_image,
                   u.name AS registered_name, u.email AS registered_email, u.avatar AS registered_avatar,
                   u.phone AS registered_phone, u.company AS registered_company
            FROM inquiries i
            LEFT JOIN products p ON i.product_id = p.id
            LEFT JOIN users u ON i.user_id = u.id
            WHERE i.id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getByReferenceNumber(string $ref): ?array
    {
        $stmt = $this->db->prepare("
            SELECT i.*, 
                   p.name AS product_name, p.stock AS product_stock, p.image AS product_image,
                   u.name AS registered_name, u.email AS registered_email, u.avatar AS registered_avatar
            FROM inquiries i
            LEFT JOIN products p ON i.product_id = p.id
            LEFT JOIN users u ON i.user_id = u.id
            WHERE i.reference_number = :ref
            LIMIT 1
        ");
        $stmt->execute(['ref' => $ref]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getByUserId(int $userId, int $limit = 50): array
    {
        $stmt = $this->db->prepare("
            SELECT i.*, p.name AS product_name, p.image AS product_image
            FROM inquiries i
            LEFT JOIN products p ON i.product_id = p.id
            WHERE i.user_id = :uid
            ORDER BY i.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Strict Customer Ownership Validation (IDOR Protection)
     */
    public function findByIdAndUserId(int $id, int $userId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT i.*, 
                   p.name AS product_name, p.stock AS product_stock, p.image AS product_image, p.description AS product_description
            FROM inquiries i
            LEFT JOIN products p ON i.product_id = p.id
            WHERE i.id = :id AND i.user_id = :uid
            LIMIT 1
        ");
        $stmt->execute(['id' => $id, 'uid' => $userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getAll(?string $status = null, ?string $priority = null, ?string $search = null, int $limit = 100): array
    {
        $sql = "
            SELECT i.*, 
                   p.name AS product_name,
                   u.name AS registered_name,
                   u.email AS registered_email,
                   u.avatar AS registered_avatar
            FROM inquiries i
            LEFT JOIN products p ON i.product_id = p.id
            LEFT JOIN users u ON i.user_id = u.id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($status) && $status !== 'all') {
            $sql .= " AND i.status = :status";
            $params['status'] = $status;
        }

        if (!empty($priority) && $priority !== 'all') {
            $sql .= " AND i.priority = :priority";
            $params['priority'] = $priority;
        }

        if (!empty($search)) {
            $sql .= " AND (i.reference_number LIKE :s1 OR i.name LIKE :s2 OR i.company LIKE :s3 OR i.phone LIKE :s4 OR p.name LIKE :s5 OR u.name LIKE :s6 OR u.email LIKE :s7)";
            $searchTerm = "%{$search}%";
            $params['s1'] = $searchTerm;
            $params['s2'] = $searchTerm;
            $params['s3'] = $searchTerm;
            $params['s4'] = $searchTerm;
            $params['s5'] = $searchTerm;
            $params['s6'] = $searchTerm;
            $params['s7'] = $searchTerm;
        }

        $sql .= " ORDER BY i.created_at DESC LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE inquiries
            SET status = :status,
                priority = :priority,
                admin_note = :admin_note,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'status' => $data['status'] ?? 'new',
            'priority' => $data['priority'] ?? 'normal',
            'admin_note' => $data['admin_note'] ?? null,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM inquiries WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getStats(): array
    {
        $stmt = $this->db->query("
            SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) AS new_count,
                SUM(CASE WHEN status IN ('contacted', 'processing') THEN 1 ELSE 0 END) AS processing_count,
                SUM(CASE WHEN status IN ('quoted', 'completed') THEN 1 ELSE 0 END) AS completed_count
            FROM inquiries
        ");
        $row = $stmt->fetch();
        return [
            'total' => (int) ($row['total'] ?? 0),
            'new' => (int) ($row['new_count'] ?? 0),
            'processing' => (int) ($row['processing_count'] ?? 0),
            'completed' => (int) ($row['completed_count'] ?? 0),
        ];
    }
}