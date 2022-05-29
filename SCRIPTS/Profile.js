function onResponse(response){
    return response.json();
}

function gradeToStars(grade){
    grade > 5 ? starnum = 5 : starnum = grade;
    let span = document.createElement('span');
    let i = 0;
    for(i=0;i<starnum;i++){
        star = document.createElement('span');
        star.classList.add('fa');
        star.classList.add('fa-star');
        star.classList.add('checked');
        span.appendChild(star);
    }
    for(i;i<5;i++){
        star = document.createElement('span');
        star.classList.add('fa');
        star.classList.add('fa-star');
        span.appendChild(star);
    }

    return span;
}

function Like(event){
    const likenum = event.currentTarget.parentNode.querySelector('.like-number');
    const post = event.currentTarget.parentNode.parentNode.parentNode;
    if(event.currentTarget.dataset.liked === 'false'){
        event.currentTarget.src = 'CSS/liked.png';
        likenum.textContent = (parseInt(likenum.textContent) + 1);
        fetch('PHP/LikeInsert.php?Post='+ post.dataset.id);
        event.currentTarget.dataset.liked = true;
    }else{
        event.currentTarget.src = 'CSS/unliked.png';
        likenum.textContent = (parseInt(likenum.textContent) - 1);
        fetch('PHP/LikeDelete.php?Post='+ post.dataset.id);
        event.currentTarget.dataset.liked = false;
    } 
}

function onJsonComments(json){
    for(let i=0;i<json.length;i++){
        const em = document.createElement('em');
        em.textContent = '@'+json[i].Username+':';
        const p = document.createElement('p');
        p.appendChild(em);
        p.insertAdjacentText('beforeend',json[i].Content);
        CommentPost.querySelector('.comments').append(p);
    }
}

function sendComment(event){
    event.preventDefault(); // prevengo il refresh
    // creo gli elementi che compongono il commento
    const CommentText = event.currentTarget.parentNode;
    const p = document.createElement('p');
    const em = document.createElement('em');
    // riempio gli elementi
    em.textContent = '@' + document.querySelector('[href="Profile.php"]').textContent + ':';
    p.appendChild(em)
    p.insertAdjacentText('beforeend',CommentText.querySelector('textarea').value);

    CommentText.parentNode.appendChild(p);
  
    fetch("PHP/insertComment.php?Post="+event.currentTarget.parentNode.parentNode.parentNode.dataset.id+"&Content="+encodeURIComponent(CommentText.querySelector('textarea').value)); 
    CommentText.querySelector('textarea').value = '';

    const num = CommentText.parentNode.parentNode.querySelector(".comment-number");
    num.textContent = parseInt(num.textContent) + 1;   
}

function ShowComments(event){
    const Post = event.currentTarget.parentNode.parentNode.parentNode;
    if(Post.querySelector('.comments').childNodes.length === 0){
        const div = document.createElement('div');
        const textarea = document.createElement('textarea');
        textarea.classList.add('textinput');
        const button = document.createElement('button');
        button.innerHTML = 'Send';
        button.classList.add('submit');
        button.addEventListener('click', sendComment);
        div.append(textarea);
        div.append(button);

        Post.querySelector('.comments').append(div);
        CommentPost = Post;
        fetch("PHP/getComments.php?Post="+Post.dataset.id).then(onResponse).then(onJsonComments);
    }else{
        if(Post.querySelector('.comments').classList.contains('hidden')){
            Post.querySelector('.comments').classList.remove('hidden');
        }else{
            Post.querySelector('.comments').classList.add('hidden');
        }
    }
}

function deletePost(event){
    fetch("PHP/deletePost.php?Post="+event.currentTarget.parentNode.dataset.id);
    event.currentTarget.parentNode.remove();
}

function onJsonPosts(json){
    for(let i=0; i<json.length; i++){
        let postDiv = document.createElement('div');
        postDiv.classList.add('post');
        postDiv.dataset.id = json[i].Id;

        let postBody = document.createElement('div');
        postBody.classList.add('post-body');
        postBody.dataset.game = json[i].Game;

        let gameimg = document.createElement('img');
        gameimg.classList.add('game-cover');
        gameimg.src = json[i][1];
        postBody.appendChild(gameimg);

        let span = document.createElement('span');
        let br = document.createElement('br');

        let title = document.createElement('h1');
        title.classList.add('post-name');
        title.textContent = json[i].Title+' ';

        let poster = document.createElement('span');
        poster.classList.add('poster');
        poster.textContent = '@'+json[i].Username+' ';

        let gameTitle = document.createElement('em');
        gameTitle.classList.add('game-name');
        gameTitle.textContent = json[i][0]+' ';

        let stars = gradeToStars(json[i].Grade);
        
        span.appendChild(title);
        span.appendChild(poster);
        span.appendChild(gameTitle);
        span.appendChild(stars);

        span.appendChild(br);

        span.insertAdjacentText('beforeend',json[i].Content);

        postBody.appendChild(span);        
        postDiv.appendChild(postBody);

        let likes = document.createElement('div');
        likes.classList.add('likes');

        let div = document.createElement('div');
        let likeimg = document.createElement('img');
        if (parseInt(json[i].Liked)){
            likeimg.src = 'CSS/liked.png';
            likeimg.dataset.liked = true;
        }else{
            likeimg.src = 'CSS/unliked.png';
            likeimg.dataset.liked = false;
        }

        likeimg.setAttribute('id','like');
        likeimg.addEventListener('click', Like);
        
        let likenum = document.createElement('span');
        likenum.classList.add('like-number');
        likenum.textContent = json[i].nLikes;

        div.appendChild(likeimg);
        div.appendChild(likenum);
        const div2 = document.createElement('div');
        let commentimg = document.createElement('img');
        commentimg.src = 'CSS/comment.png';
        commentimg.setAttribute('id','comment');
        commentimg.addEventListener('click', ShowComments);
        let commentnum = document.createElement('span');
        commentnum.classList.add('comment-number');
        commentnum.textContent = json[i].nComments;


        div2.append(commentimg);
        div2.append(commentnum);

        likes.appendChild(div);
        likes.appendChild(div2);

        postDiv.appendChild(likes);
        const commentbox = document.createElement('div');
        commentbox.classList.add('comments');
        postDiv.appendChild(commentbox); 

        const deleteButton = document.createElement('button');
        deleteButton.addEventListener('click', deletePost);
        deleteButton.textContent = 'Cancella Post';
        deleteButton.classList.add('deletebutton');
        postDiv.appendChild(deleteButton);
        document.querySelector('#postsbox').appendChild(postDiv);
    }
}

function fetchPosts() {
    fetch("PHP/getPosts.php?CurrentUser=true").then(onResponse).then(onJsonPosts);
}

fetchPosts();