const tabLogin = document.getElementById('tab-login');
const tabSignup = document.getElementById('tab-signup');
const formLogin = document.getElementById('form-login');
const formSignup = document.getElementById('form-signup');

if (tabLogin && tabSignup && formLogin && formSignup) {
  // todo: cleanup?
  tabLogin.addEventListener('click', () => {
    tabSignup.classList.remove('active');
    formSignup.classList.remove('active');
    tabLogin.classList.add('active');
    formLogin.classList.add('active');
  });

  tabSignup.addEventListener('click', () => {
    tabSignup.classList.add('active');
    formSignup.classList.add('active');
    
    tabLogin.classList.remove('active');
    formLogin.classList.remove('active');
  });
}

const linkForgot = document.getElementById('link-forgot');
if (linkForgot) {
  linkForgot.addEventListener('click', (e) => {
    alert('Password reset link sent (demo). In production, this would email a secure link.');
  });
}

const loginFormEl = document.getElementById('form-login');
const roleSelect = document.getElementById('login-role');
const use2fa = document.getElementById('login-use-2fa');

const twofaBackdrop = document.getElementById('twofa-backdrop');
const twofaCode = document.getElementById('twofa-code');
const twofaVerify = document.getElementById('twofa-verify');
const twofaCancel = document.getElementById('twofa-cancel');

function goToRole(role) {
  if (role === 'donor') window.location.href = './donor-dashboard.html';
  else if (role === 'staff') window.location.href = './staff-dashboard.html';
  else if (role === 'admin') window.location.href = './admin-dashboard.html';
  else alert('Select a role to continue (demo).');
}

if (loginFormEl) {
  loginFormEl.addEventListener('submit', (e) => {
    e.preventDefault();
    const role = roleSelect?.value;
  });
}

const signupFormEl = document.getElementById('form-signup');
if (signupFormEl) {
  signupFormEl.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('Account created (demo). You can now log in.');
    tabLogin?.click();
  });
}
