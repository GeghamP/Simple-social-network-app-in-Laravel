$(document).ready(function(){
	let post;
	$('.interaction').click(function(event){
		event.preventDefault();
		post = event.target.parentNode.parentNode;
		
		//when clicking edit
		if(event.target.classList.contains('edit-post')){
			postTextElem = post.querySelector('.bost-body-text');
			//console.log(postTextElem);
			const postText = postTextElem.textContent;
			$('#post_text').val(postText);
			$('#edit_modal').modal();
		}
		
		//when clicking like
		else if(event.target.classList.contains('like')){
			$.ajax({
				method: 'POST',
				url: './like',
				data: {
					is_like: 1,
					post_id: post.dataset['postid'],
					_token: $('#like-dislike-token').val()
				},
				success: function(data){
					console.log("Liked");
					console.log(data);
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
		editAjaxCall(post.dataset['postid']);
	});
	
	function editAjaxCall(post_id){
		$.ajax({
			method: 'POST',
			url: './edit',
			data: {
				post_text: $('#post_text').val(),
				post_id: post_id,
				_token: $('#post-edit-token').val()
			},
				
			success: function(data){
				postTextElem.textContent = data['new_text'];
			},
			error: function(err){
				console.log('error');
				console.log(err);
			}
		})	
	}
	
});

