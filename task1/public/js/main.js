// event listeners fopr input elements
document.getElementById('page-input').addEventListener('change', updatePage);
document.getElementById('limit-input').addEventListener('change', updateLimit);

// event listeners for header
document.getElementById('posts-heading').addEventListener('click', () => location.reload());


// Load first page of posts on page load
document.addEventListener('DOMContentLoaded', () => {
    getPosts();
});