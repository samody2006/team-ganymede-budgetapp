// Selecting elements and caching into variables
const usernameCta = document.querySelector('.username-cta');
const emailCta = document.querySelector('.email-cta');
const emailLabel = document.querySelectorAll('.email-tr')[0];
const emailInput = document.querySelectorAll('.email-tr')[1];
const usernameLabel = document.querySelectorAll('.username-tr')[0];
const usernameInput = document.querySelectorAll('.username-tr')[1];

// changeToUsername function
changeToUsername = event => {
	emailLabel.classList.add('display-none');
	emailInput.classList.add('display-none');
	usernameCta.style.backgroundColor = 'rgba(65, 66, 78, 0.99)';
	usernameCta.style.color = '#f0f0f0';
	emailCta.style.backgroundColor = '#fff';
	emailCta.style.color = 'rgba(65, 66, 78, 0.99)';
	emailCta.style.border = '1px solid rgba(65, 66, 78, 0.99)';
	usernameLabel.classList.remove('username-tr');
	usernameInput.classList.remove('username-tr');
	event.preventDefault();
};

// Click event listener to trigger the changeToUsername when a user clicks on username button
usernameCta.addEventListener('click', changeToUsername);

// changeToEmail function
changeToEmail = event => {
	emailLabel.classList.remove('display-none');
	emailInput.classList.remove('display-none');
	usernameLabel.classList.add('username-tr');
	usernameInput.classList.add('username-tr');
	usernameCta.style.backgroundColor = 'white';
	usernameCta.style.color = 'rgba(65, 66, 78, 0.99)';
	emailCta.style.color = '#f0f0f0';
	emailCta.style.backgroundColor = 'rgba(65, 66, 78, 0.99)';
};
// Click event listener to trigger the changeToEmail when a user clicks on email button
emailCta.addEventListener('click', changeToEmail);
