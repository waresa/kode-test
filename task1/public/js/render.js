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

// render no posts found message
function renderNoPosts() {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = '';

    const noPosts = document.createElement('h2');
    noPosts.innerText = 'No posts found';

    resultDiv.appendChild(noPosts);
}

// render error message
function renderInternalError() {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = '';

    const noPosts = document.createElement('h2');
    noPosts.innerText = 'Internal server error';

    resultDiv.appendChild(noPosts);
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