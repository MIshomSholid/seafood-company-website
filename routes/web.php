<?php

$route = $_GET['route'] ?? 'home';

switch ($route) {

    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    case 'home':
        require_once __DIR__ . '/../app/controllers/HomeController.php';

        $controller = new HomeController();
        $controller->index();
        break;


    /*
    |--------------------------------------------------------------------------
    | PUBLIC PRODUCTS
    |--------------------------------------------------------------------------
    */

    case 'products':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();
        $controller->index();
        break;

    case 'product/show':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->show($id);
        break;


    /*
    |--------------------------------------------------------------------------
    | COMMENTS
    |--------------------------------------------------------------------------
    */

    case 'comments':
        require_once __DIR__ . '/../app/controllers/CommentController.php';

        $controller = new CommentController();
        $controller->index();
        break;

    case 'comment/store':
        require_once __DIR__ . '/../app/controllers/CommentController.php';

        $controller = new CommentController();
        $controller->store();
        break;

    case 'comment/update':
        require_once __DIR__ . '/../app/controllers/CommentController.php';

        $controller = new CommentController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->update($id);
        break;

    case 'comment/delete':
        require_once __DIR__ . '/../app/controllers/CommentController.php';

        $controller = new CommentController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->delete($id);
        break;


    /*
    |--------------------------------------------------------------------------
    | RATINGS
    |--------------------------------------------------------------------------
    */

    case 'rating/store':
        require_once __DIR__ . '/../app/controllers/RatingController.php';

        $controller = new RatingController();
        $controller->store();
        break;

    case 'rating/delete':
        require_once __DIR__ . '/../app/controllers/RatingController.php';

        $controller = new RatingController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->delete($id);
        break;


    /*
    |--------------------------------------------------------------------------
    | ADMIN AUTHENTICATION
    |--------------------------------------------------------------------------
    */

    case 'admin/login':
        require_once __DIR__ . '/../app/controllers/AdminController.php';

        $controller = new AdminController();
        $controller->login();
        break;

    case 'admin/authenticate':
        require_once __DIR__ . '/../app/controllers/AdminController.php';

        $controller = new AdminController();
        $controller->authenticate();
        break;

    case 'admin/logout':
        require_once __DIR__ . '/../app/controllers/AdminController.php';

        $controller = new AdminController();
        $controller->logout();
        break;


    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    case 'admin/dashboard':
        require_once __DIR__ . '/../app/controllers/AdminController.php';

        $controller = new AdminController();
        $controller->dashboard();
        break;


    /*
    |--------------------------------------------------------------------------
    | ADMIN PRODUCTS
    |--------------------------------------------------------------------------
    */

    case 'admin/products':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();
        $controller->adminIndex();
        break;

    case 'admin/products/create':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();
        $controller->adminCreate();
        break;

    case 'admin/products/store':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();
        $controller->store();
        break;

    case 'admin/products/show':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->adminShow($id);
        break;

    case 'admin/products/edit':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->edit($id);
        break;

    case 'admin/products/update':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->update($id);
        break;

    case 'admin/products/delete':
        require_once __DIR__ . '/../app/controllers/ProductController.php';

        $controller = new ProductController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->delete($id);
        break;


    /*
    |--------------------------------------------------------------------------
    | AI CHAT ASSISTANT
    |--------------------------------------------------------------------------
    */

    case 'chat/init':
    case 'chat/session':
        require_once __DIR__ . '/../app/controllers/ChatController.php';

        $controller = new ChatController();
        $controller->initSession();
        break;

    case 'chat/send':
        require_once __DIR__ . '/../app/controllers/ChatController.php';

        $controller = new ChatController();
        $controller->send();
        break;

    case 'chat/history':
        require_once __DIR__ . '/../app/controllers/ChatController.php';

        $controller = new ChatController();
        $controller->history();
        break;


    /*
    |--------------------------------------------------------------------------
    | INQUIRIES & PERMINTAAN PENAWARAN (PUBLIC)
    |--------------------------------------------------------------------------
    */

    case 'inquiry/store':
    case 'inquiries/store':
        require_once __DIR__ . '/../app/controllers/InquiryController.php';

        $controller = new InquiryController();
        $controller->store();
        break;


    /*
    |--------------------------------------------------------------------------
    | ADMIN INQUIRIES & PENAWARAN
    |--------------------------------------------------------------------------
    */

    case 'admin/inquiries':
        require_once __DIR__ . '/../app/controllers/InquiryController.php';

        $controller = new InquiryController();
        $controller->adminIndex();
        break;

    case 'admin/inquiries/show':
        require_once __DIR__ . '/../app/controllers/InquiryController.php';

        $controller = new InquiryController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->adminShow($id);
        break;

    case 'admin/inquiries/update':
        require_once __DIR__ . '/../app/controllers/InquiryController.php';

        $controller = new InquiryController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->adminUpdate($id);
        break;

    case 'admin/inquiries/delete':
        require_once __DIR__ . '/../app/controllers/InquiryController.php';

        $controller = new InquiryController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->adminDelete($id);
        break;


    /*
    |--------------------------------------------------------------------------
    | ADMIN AI CHAT LOGS
    |--------------------------------------------------------------------------
    */

    case 'admin/chat':
        require_once __DIR__ . '/../app/controllers/ChatController.php';

        $controller = new ChatController();
        $controller->adminIndex();
        break;

    case 'admin/chat/show':
        require_once __DIR__ . '/../app/controllers/ChatController.php';

        $controller = new ChatController();

        $id = (int) ($_GET['id'] ?? 0);

        $controller->adminShow($id);
        break;


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER AUTHENTICATION & GOOGLE LOGIN
    |--------------------------------------------------------------------------
    */

    case 'auth/login':
    case 'login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';

        $controller = new AuthController();
        $controller->login();
        break;

    case 'auth/google':
        require_once __DIR__ . '/../app/controllers/AuthController.php';

        $controller = new AuthController();
        $controller->googleRedirect();
        break;

    case 'auth/google/callback':
        require_once __DIR__ . '/../app/controllers/AuthController.php';

        $controller = new AuthController();
        $controller->googleCallback();
        break;

    case 'auth/logout':
    case 'logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';

        $controller = new AuthController();
        $controller->logout();
        break;


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER ACCOUNT & INQUIRY TRACKING
    |--------------------------------------------------------------------------
    */

    case 'account':
    case 'account/profile':
        require_once __DIR__ . '/../app/controllers/AccountController.php';

        $controller = new AccountController();
        $controller->index();
        break;

    case 'account/inquiry':
    case 'account/inquiries/show':
        require_once __DIR__ . '/../app/controllers/AccountController.php';

        $controller = new AccountController();
        $controller->inquiryDetail();
        break;

    case 'account/update-profile':
        require_once __DIR__ . '/../app/controllers/AccountController.php';

        $controller = new AccountController();
        $controller->updateProfile();
        break;


    /*
    |--------------------------------------------------------------------------
    | 404
    |--------------------------------------------------------------------------
    */

    default:
        http_response_code(404);

        echo '404 - Halaman tidak ditemukan';
        break;
}