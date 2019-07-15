$(document).ready(function(){
	//Pusher.logToConsole = true;

    var pusher = new Pusher('2b99ea80122390530f7e', {
		cluster: 'ap2',
		forceTLS: true
    });

    var channel = pusher.subscribe('RatingChangeChannel');
    channel.bind('RatingChangeEvent', function(data) {
		let post = data.post;
		updateRating(post);
    });
	
	//Called when RatingChangeEvent is triggered
	function updateRating({ id, num_likes, num_dislikes }){
		let posts = document.getElementsByClassName('post');
		[].forEach.call(posts,(post) => {
			if(post.dataset['postid'] == id){
				post.querySelector('.num-likes').textContent = num_likes;
				post.querySelector('.num-dislikes').textContent = num_dislikes;
			}
		});
	}
	
	let post;
	$('.interaction').click(function(event){
		event.preventDefault();
		post = getPost(event);
		
		//when clicking edit
		if(event.target.classList.contains('edit-post')){
			postTextElem = post.querySelector('.bost-body-text');
			const postText = postTextElem.textContent;
			$('#post_text').val(postText);
			$('#edit_modal').modal();
		}
		
		//when clicking like
		else if(event.target.classList.contains('fa-thumbs-up') || event.target.classList.contains('fa-thumbs-down')){
			
			let like = event.currentTarget.querySelector('.like');
			let dislike = event.currentTarget.querySelector('.dislike');
			let is_like = event.target.parentElement.classList.contains('like') ? 1 : 0;
			
			$.ajax({
				method: 'POST',
				url: './like',
				data: {
					is_like: is_like,
					post_id: post.dataset['postid'],
					_token: $('#post-tools-token').val()
				},
				success: function(data){
					
					if(is_like === 1){
						let like_icon = like.querySelector('i');
						like.innerHTML = like_icon.classList.contains('fas') ? '<i class = "far fa-thumbs-up"></i>' : '<i class = "fas fa-thumbs-up"></i>';
						dislike.innerHTML = '<i class = "far fa-thumbs-down"></i>';
					}
					else if(is_like === 0){
						let dislike_icon = dislike.querySelector('i');
						dislike.innerHTML = dislike_icon.classList.contains('fas') ? '<i class = "far fa-thumbs-down"></i>' : '<i class = "fas fa-thumbs-down"></i>';
						like.innerHTML = '<i class = "far fa-thumbs-up"></i>';
					}
				},
				error: function(err){
					console.log('error');
					console.log(err);
				}
			});
		}

	});	
	
	//when clicking Save button
	$('#save_post').click(function(){
		ajaxCall(post.dataset['postid'],'editpost');
	});
	$('.delete-post').click(function(event){
		ajaxCall(getPost(event).dataset['postid'],'deletepost');
	});
	
	function getPost(event){
		return event.target.closest('article');
	}
	
	function ajaxCall(post_id, action){
		$.ajax({
			method: 'POST',
			url: './'+action,
			data: {
				post_text: $('#post_text').val(),
				post_id: post_id,
				_token: $('#post-tools-token').val()
			},
				
			success: function(data){
				if(action === 'editpost'){
					postTextElem.textContent = data['new_text'];
				}
				else if(action === 'deletepost'){
					window.location.href = './dashboard';
				}
			},
			error: function(err){
				console.log('error');
				console.log(err);
			}
		})	
	}
	
});

