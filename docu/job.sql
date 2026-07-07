CREATE DATABASE job ;
use job ; 

CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(225) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    job_title VARCHAR(100) NULL,
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_users_email (email),
    INDEX idx_users_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS companies (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(225) NOT NULL,
    number_employees INT NULL DEFAULT NULL,
    website_name VARCHAR(225) NULL DEFAULT NULL,
    number_phone VARCHAR(20) NULL DEFAULT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    
    CONSTRAINT fk_companies_user_id FOREIGN KEY (user_id) 
        REFERENCES users(id) ON DELETE CASCADE,
    
    INDEX idx_companies_user_id (user_id),
    INDEX idx_companies_name (name),
    INDEX idx_companies_deleted_at (deleted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS job_listings (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(225) NOT NULL,
    description TEXT NOT NULL,
    salary DECIMAL(10, 2) NULL DEFAULT NULL,
    location VARCHAR(225) NOT NULL,
    company_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    CONSTRAINT fk_job_listings_company_id FOREIGN KEY (company_id) 
        REFERENCES companies(id) ON DELETE CASCADE,
    CONSTRAINT fk_job_listings_user_id FOREIGN KEY (user_id) 
        REFERENCES users(id) ON DELETE CASCADE,
    
    INDEX idx_job_listings_company_id (company_id),
    INDEX idx_job_listings_user_id (user_id),
    INDEX idx_job_listings_name (name),
    INDEX idx_job_listings_location (location),
    INDEX idx_job_listings_salary (salary),
    INDEX idx_job_listings_deleted_at (deleted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS applications (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(225) NOT NULL,
    cv VARCHAR(225) NOT NULL,
    status BOOLEAN NOT NULL DEFAULT FALSE,
    user_id BIGINT UNSIGNED NOT NULL,
    job_id BIGINT UNSIGNED NOT NULL,
    processed_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    
    CONSTRAINT fk_applications_user_id FOREIGN KEY (user_id) 
        REFERENCES users(id) ON DELETE CASCADE ,
    CONSTRAINT fk_applications_job_id FOREIGN KEY (job_id) 
        REFERENCES job_listings(id) ON DELETE CASCADE,
    
    INDEX idx_applications_user_id (user_id),
    INDEX idx_applications_job_id (job_id),
    INDEX idx_applications_status (status),
    INDEX idx_applications_deleted_at (deleted_at),
    INDEX idx_applications_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


