// get the login element
const login = document.querySelector('.login');
const signupBtn = document.querySelector('.signup');
const loginBtn = document.querySelector('.login');

// const modalLogin = document.querySelector('.modal-login');
const signupForm = document.querySelector('.signup-form1');
const loginForm = document.querySelector('.login-form1');

// function to trigger login page
const loginTrigger = () => {
	loginForm.style.display = 'flex';
	signupForm.style.display = 'none';
	signupBtn.style.backgroundColor = 'white';
	signupBtn.style.color = 'rgb(65, 66, 78)';
	loginBtn.style.color = 'white';
	loginBtn.style.backgroundColor = 'rgb(65, 66, 78)';
};

// function to open the signup form
const signupTrigger = () => {
	loginForm.style.display = 'none';
	signupForm.style.display = 'flex';
	signupBtn.style.backgroundColor = 'rgb(65, 66, 78)';
	signupBtn.style.color = 'white';
	loginBtn.style.backgroundColor = 'white';
	loginBtn.style.color = 'rgb(65, 66, 78)';
};

signupBtn.addEventListener('click', signupTrigger);
login.addEventListener('click', loginTrigger);
