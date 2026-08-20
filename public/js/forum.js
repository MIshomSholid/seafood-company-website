document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submit-comment");

    if (!submitButton) {
        return;
    }

    submitButton.addEventListener("click", function () {
        const commentInput = document.getElementById("user-comment");
        const commentList = document.getElementById("comment-list");

        const commentText = commentInput.value.trim();

        if (commentText !== "") {
            const newComment = document.createElement("li");

            newComment.classList.add("list-group-item");

            newComment.textContent = `User: "${commentText}"`;

            commentList.appendChild(newComment);

            commentInput.value = "";
        } else {
            alert("Tolong tulis komentar terlebih dahulu.");
        }
    });
});