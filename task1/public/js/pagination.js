// Fetch and render the next page of posts
async function nextPage() {
    const nextPage = currentPage + 1;
    const response = await fetch(`/api/posts?page=${nextPage}&limit=2`);
    const result = await response.json();

    // Check if there are posts on the next page
    if (result.posts.length > 0) {
        currentPage++;
        getPosts();
    } else {
        showFeedback('No more posts');
    }
}

// Fetch and render the previous page of posts
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        getPosts();
    }
}