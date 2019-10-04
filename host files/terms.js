// Hiding the modal and then caching it into a variable
const modalHide = $('.modal-dark').hide();

// Displaying the modal when the "terms of service" is clicked
$('.term-service').click(function() {
	modalHide.show();
});

$('header span').click(function() {
	const modalHide = $('.modal-dark').hide();
});
