$(document).ready(function(){
	let post;
	$('.interaction').click(function(event){
		event.preventDefault();
		post = getPost(event);
		
		//when clicking edit
		if(event.target.classList.contains('edit-post')){
			postTextElem = post.querySelector('.bost-body-text');
			//console.log(postTextElem);
			const postText = postTextElem.textContent;
			$('#post_text').val(postText);
			$('#edit_modal').modal();
		}
		
		//when clicking like
		else if(event.target.classList.contains('like') || event.target.classList.contains('dislike')){
			let like = event.currentTarget.querySelector('.like');
			let dislike = event.currentTarget.querySelector('.dislike');
			let is_like = event.target.classList.contains('like') ? 1 : 0;
			
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
						like.textContent = like.textContent === 'Like' ? 'You liked it' : 'Like';
						dislike.textContent = 'Dislike';
					}
					else if(is_like === 0){
						dislike.textContent = dislike.textContent === 'Dislike' ? 'You disliked it' : 'Dislike';
						like.textContent = 'Like';
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
		return event.target.parentNode.parentNode;
	}
	
	function ajaxCall(post_id, action){
		console.log('caal');
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

