import './bootstrap';

const API_URL = 'http://localhost:8000/api';
let token = localStorage.getItem('token');
let currentPage = 1;
let currentSection = 'jobs';


const navLinks = document.getElementById('navLinks');
const authForms = document.getElementById('authForms');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const navAuth = document.getElementById('navAuth');
const navUser = document.getElementById('navUser');
const userName = document.getElementById('userName');
const jobsList = document.getElementById('jobsList');
const applicationsList = document.getElementById('applicationsList');
const companiesList = document.getElementById('companiesList');
const jobsPagination = document.getElementById('jobsPagination');
const jobSearch = document.getElementById('jobSearch');
const searchBtn = document.getElementById('searchBtn');
const createJobBtn = document.getElementById('createJobBtn');
const createJobModal = document.getElementById('createJobModal');
const createJobForm = document.getElementById('createJobForm');


function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function setAuthUI(user) {
    if (token && user) {
        navAuth.style.display = 'none';
        navUser.style.display = 'flex';
        userName.textContent = user.name;
        authForms.style.display = 'none';
    } else {
        navAuth.style.display = 'flex';
        navUser.style.display = 'none';
        authForms.style.display = 'none';
    }
}


async function apiRequest(endpoint, method = 'GET', data = null) {
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const options = {
        method,
        headers,
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(`${API_URL}${endpoint}`, options);
        const result = await response.json();
        
        if (!response.ok) {
            if (response.status === 401) {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                token = null;
                setAuthUI(null);
                window.location.reload();
            }
            throw new Error(result.message || 'Something went wrong');
        }
        
        return result;
    } catch (error) {
        showToast(error.message, 'error');
        throw error;
    }
}

// Auth
document.getElementById('loginBtn').addEventListener('click', () => {
    authForms.style.display = 'block';
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
});

document.getElementById('registerBtn').addEventListener('click', () => {
    authForms.style.display = 'block';
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
});

document.getElementById('loginFormElement').addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    try {
        const data = await apiRequest('/login', 'POST', { email, password });
        token = data.access_token;
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(data.user));
        setAuthUI(data.user);
        showToast('Login successful!');
        authForms.style.display = 'none';
        loadJobs();
    } catch (error) {
        // Error handled in apiRequest
    }
});

document.getElementById('registerFormElement').addEventListener('submit', async (e) => {
    e.preventDefault();
    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;
    const passwordConfirm = document.getElementById('registerPasswordConfirm').value;
    const job_title = document.getElementById('registerJobTitle').value;

    if (password !== passwordConfirm) {
        showToast('Passwords do not match', 'error');
        return;
    }

    try {
        const data = await apiRequest('/register', 'POST', { name, email, password, password_confirmation: passwordConfirm, job_title });
        token = data.access_token;
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(data.user));
        setAuthUI(data.user);
        showToast('Registration successful!');
        authForms.style.display = 'none';
        loadJobs();
    } catch (error) {
       
    }
});

document.getElementById('logoutBtn').addEventListener('click', async () => {
    try {
        await apiRequest('/logout', 'POST');
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        token = null;
        setAuthUI(null);
        showToast('Logged out successfully');
        loadJobs();
    } catch (error) {
       
    }
});


document.getElementById('jobsLink').addEventListener('click', () => {
    currentSection = 'jobs';
    document.getElementById('jobsSection').style.display = 'block';
    document.getElementById('applicationsSection').style.display = 'none';
    document.getElementById('companiesSection').style.display = 'none';
    loadJobs();
});

document.getElementById('applicationsLink').addEventListener('click', () => {
    currentSection = 'applications';
    document.getElementById('jobsSection').style.display = 'none';
    document.getElementById('applicationsSection').style.display = 'block';
    document.getElementById('companiesSection').style.display = 'none';
    loadApplications();
});

document.getElementById('companiesLink').addEventListener('click', () => {
    currentSection = 'companies';
    document.getElementById('jobsSection').style.display = 'none';
    document.getElementById('applicationsSection').style.display = 'none';
    document.getElementById('companiesSection').style.display = 'block';
    loadCompanies();
});


async function loadJobs(page = 1) {
    const search = jobSearch.value;
    jobsList.innerHTML = '<div class="loading">Loading jobs...</div>';

    try {
        const url = `/job?page=${page}${search ? `&search=${search}` : ''}`;
        const data = await apiRequest(url);
        
        if (data.data && data.data.length === 0) {
            jobsList.innerHTML = '<p>No jobs found.</p>';
            jobsPagination.innerHTML = '';
            return;
        }

        jobsList.innerHTML = data.data.map(job => `
            <div class="card">
                <h3>${job.name}</h3>
                <p>${job.description}</p>
                <div class="meta">💰 $${job.salary} | 📍 ${job.location}</div>
                <div class="meta">🏢 ${job.company?.name || 'N/A'}</div>
                ${token ? `
                    <button onclick="applyForJob(${job.id})" class="btn btn-success" style="margin-top: 0.5rem;">Apply</button>
                ` : ''}
            </div>
        `).join('');

        
        if (data.meta) {
            const totalPages = data.meta.last_page;
            let paginationHtml = '';
            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<button onclick="loadJobs(${i})" class="${i === page ? 'active' : ''}">${i}</button>`;
            }
            jobsPagination.innerHTML = paginationHtml;
        }
    } catch (error) {
        jobsList.innerHTML = '<p>Error loading jobs. Please try again.</p>';
    }
}

// Load Applications
async function loadApplications() {
    if (!token) {
        applicationsList.innerHTML = '<p>Please login to view your applications.</p>';
        return;
    }

    applicationsList.innerHTML = '<div class="loading">Loading applications...</div>';

    try {
        const data = await apiRequest('/Application');
        
        if (data.data && data.data.length === 0) {
            applicationsList.innerHTML = '<p>You haven\'t applied to any jobs yet.</p>';
            return;
        }

        applicationsList.innerHTML = data.data.map(app => `
            <div class="card">
                <h3>${app.title}</h3>
                <p>Job: ${app.job?.name || 'N/A'}</p>
                <div class="meta">Status: <span class="${app.status ? 'status-active' : 'status-inactive'}">${app.status ? 'Approved' : 'Pending'}</span></div>
                <div class="meta">Applied: ${app.created_at}</div>
            </div>
        `).join('');
    } catch (error) {
        applicationsList.innerHTML = '<p>Error loading applications. Please try again.</p>';
    }
}


async function loadCompanies() {
    companiesList.innerHTML = '<div class="loading">Loading companies...</div>';

    try {
        const data = await apiRequest('/Companies');
        
        if (data.data && data.data.length === 0) {
            companiesList.innerHTML = '<p>No companies found.</p>';
            return;
        }

        companiesList.innerHTML = data.data.map(company => `
            <div class="card">
                <h3>${company.name}</h3>
                <div class="meta">👥 ${company.number_employees || 'N/A'} employees</div>
                <div class="meta">🌐 ${company.website_name || 'N/A'}</div>
                <div class="meta">📞 ${company.number_phone || 'N/A'}</div>
            </div>
        `).join('');
    } catch (error) {
        companiesList.innerHTML = '<p>Error loading companies. Please try again.</p>';
    }
}


window.applyForJob = async function(jobId) {
    if (!token) {
        showToast('Please login first', 'error');
        return;
    }

    try {
        const result = await apiRequest('/Application', 'POST', {
            title: 'Application for Job #' + jobId,
            cv: 'cvs/sample.pdf',
            status: false,
            job_id: jobId,
            user_id: JSON.parse(localStorage.getItem('user')).id
        });

        showToast('Application submitted successfully!');
        loadJobs(currentPage);
    } catch (error) {
        showToast('Failed to submit application', 'error');
    }
};


searchBtn.addEventListener('click', () => loadJobs(1));
jobSearch.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') loadJobs(1);
});


createJobBtn.addEventListener('click', async () => {
    if (!token) {
        showToast('Please login first', 'error');
        return;
    }

    
    try {
        const data = await apiRequest('/Companies');
        const select = document.getElementById('jobCompany');
        select.innerHTML = data.data.map(c => 
            `<option value="${c.id}">${c.name}</option>`
        ).join('');
        createJobModal.style.display = 'flex';
    } catch (error) {
        showToast('Error loading companies', 'error');
    }
});

document.querySelector('.close').addEventListener('click', () => {
    createJobModal.style.display = 'none';
});

createJobForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const jobData = {
        name: document.getElementById('jobTitle').value,
        description: document.getElementById('jobDescription').value,
        salary: parseFloat(document.getElementById('jobSalary').value),
        location: document.getElementById('jobLocation').value,
        company_id: parseInt(document.getElementById('jobCompany').value),
    };

    try {
        await apiRequest('/job', 'POST', jobData);
        showToast('Job posted successfully!');
        createJobModal.style.display = 'none';
        createJobForm.reset();
        loadJobs(1);
    } catch (error) {
        showToast('Failed to post job', 'error');
    }
});

// Initialize
function init() {
    const user = JSON.parse(localStorage.getItem('user'));
    if (token && user) {
        setAuthUI(user);
    }
    loadJobs();
}

// Close modal on outside click
window.addEventListener('click', (e) => {
    if (e.target === createJobModal) {
        createJobModal.style.display = 'none';
    }
});

init();