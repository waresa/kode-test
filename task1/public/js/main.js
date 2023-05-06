let currentPage = 1;

//post request to create a new post
async function createPost() {

    // Get the values from the form
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const userId = document.getElementById('user_id').value;

    // Make a POST request to the server
    const response = await fetch('/api/posts', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },

        // Convert JS object to JSON string
        body: JSON.stringify({ title, content, user_id: userId })
    });

    const result = await response.json();
    closeCreatePostForm();
    getPosts();

    if (response.status === 200) {
        //put the newTitle in the feedback
        showFeedback(`${result.message}`);
    } else {
        showFeedback('Error creating post');
    }
}

//
async function getPostById() {
    const id = document.getElementById('search_post_id').value;

    const response = await fetch(`/api/posts/${id}`);
    const result = await response.json();

    // Check if the result is an error message or a post object
    if (result.error) {
        showFeedback(result.error);
    } else if (!result.title) {
        showFeedback(`No post found with id ${id}`);
    } else {
        renderPosts([result]);
    }

    //print result
    console.log(result);
}

async function getPosts() {
    const response = await fetch(`/api/posts?page=${currentPage}&limit=2`);
    const result = await response.json();
    renderPosts(result);

    // Update the page number element
    document.getElementById('page-number').innerText = `Page ${currentPage}`;
}

function renderPosts(posts) {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = '';

    posts.forEach(post => {
        const postDiv = document.createElement('div');
        postDiv.className = 'post';

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

        resultDiv.appendChild(postDiv);
    });
}

async function nextPage() {
    const nextPage = currentPage + 1;
    const response = await fetch(`/api/posts?page=${nextPage}&limit=2`);
    const result = await response.json();

    if (result.length > 0) {
        currentPage++;
        getPosts();
    } else {
        showFeedback('No more posts');
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        getPosts();
    }
}

function openCreatePostForm() {
    document.getElementById('create-post-form').style.display = 'flex';
}

function closeCreatePostForm() {
    document.getElementById('create-post-form').style.display = 'none';
}

function showFeedback(message) {
    const feedback = document.getElementById('feedback');
    feedback.innerText = message;
    feedback.style.display = 'block';
    setTimeout(() => {
        feedback.style.display = 'none';
    }, 3000);
}

// Load the first page of posts on page load
document.addEventListener('DOMContentLoaded', () => {
    getPosts();
});