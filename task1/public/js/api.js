let currentPage = 1;

// Create a new post
async function createPost() {
    // Get values from the form
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const userId = document.getElementById('user_id').value;

    // Send POST request to the server
    const response = await fetch('/api/posts', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ title, content, user_id: userId })
    });

    const result = await response.json();
    closeCreatePostForm();
    getPosts();

    // Show feedback based on response status
    if (response.status === 200) {
        showFeedback(`${result.message}`);
    } else {
        showFeedback('Error creating post');
    }
}

// Fetch a post by its ID
async function getPostById() {
    const id = document.getElementById('search-post-id').value;
    const response = await fetch(`/api/posts/${id}`);
    const result = await response.json();

    // Show feedback or render the post
    if (result.error) {
        showFeedback(result.error);
    } else if (!result.title) {
        showFeedback(`No post found with id ${id}`);
    } else {
        renderPosts([result]);
    }
}

// Fetch and render posts with pagination
async function getPosts() {
    const limit = document.getElementById('limit-input').value || 2;

    // Make a GET request to the server to get the posts for the current page
    const response = await fetch(`/api/posts?page=${currentPage}&limit=${limit}`);
    const result = await response.json();

    console.log(result);

    //check for internal server error
    if (response.status === 500) {
        renderInternalError();
        return;
    }

    // Check if the input page number is higher than the total number of pages
    if (currentPage > result.totalPages) {
        currentPage = result.totalPages;
        return getPosts();
    }

    // if there is posts on the current page, render them
    if (result.posts) {
        renderPosts(result.posts);
    } else {
        renderNoPosts();
    }

    // Update the page-input value with the current page number
    document.getElementById('page-input').value = currentPage;

    // Update the total-pages span element with the total number of pages
    document.getElementById('total-pages').innerText = ` of ${result.totalPages}`;
}

//update page number based on input
async function updatePage() {
    const newPage = parseInt(document.getElementById('page-input').value);
    const limit = document.getElementById('limit-input').value || 2;

    const response = await fetch(`/api/posts?page=1&limit=${limit}`);
    const result = await response.json();
    const totalPages = result.totalPages;

    if (newPage > 0 && newPage <= totalPages) {
        currentPage = newPage;
    } else if (newPage > totalPages) {
        currentPage = totalPages;
        document.getElementById('page-input').value = currentPage;
    }

    getPosts();
}

//update limit and page number based on input
function updateLimit() {
    updatePage();
    getPosts();
}