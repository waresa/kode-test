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

    // Check if the input page number is higher than the total number of pages
    if (currentPage > result.totalPages) {
        currentPage = result.totalPages;
        return getPosts();
    }

    renderPosts(result.posts);

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

// Render posts on the page
function renderPosts(posts) {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = '';

    // Create and append post elements
    posts.forEach(post => {
        const postDiv = document.createElement('div');
        postDiv.className = 'post';

        const postId = document.createElement('p');
        postId.innerText = `ID: ${post.id}`;

        const title = document.createElement('h2');
        title.innerText = post.title;

        const content = document.createElement('h3');
        content.innerText = post.content;

        const userId = document.createElement('p');
        userId.innerText = `By user: ${post.user_id}`;

        const createdDate = document.createElement('p');
        createdDate.innerText = `Posted: ${post.created_date}`;

        postDiv.appendChild(title);
        postDiv.appendChild(content);
        postDiv.appendChild(userId);
        postDiv.appendChild(createdDate);
        postDiv.appendChild(postId);

        resultDiv.appendChild(postDiv);
    });
}

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

// Show create post form
function openCreatePostForm() {
    document.getElementById('create-post-form').style.display = 'flex';
}

// Hide create post form
function closeCreatePostForm() {
    document.getElementById('create-post-form').style.display = 'none';
}

// Show temporary feedback message
function showFeedback(message) {
    const feedback = document.getElementById('feedback');
    feedback.innerText = message;
    feedback.style.display = 'block';
    setTimeout(() => {
        feedback.style.display = 'none';
    }, 3000);
}

// event listeners fopr input elements
document.getElementById('page-input').addEventListener('change', updatePage);
document.getElementById('limit-input').addEventListener('change', updateLimit);

// event listeners for header
document.getElementById('posts-heading').addEventListener('click', () => location.reload());


// Load first page of posts on page load
document.addEventListener('DOMContentLoaded', () => {
    getPosts();
});