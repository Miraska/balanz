<?php
/**
 * Template Name: About Us
 * 
 * About Us Page Template
 * 
 * @package Balanz
 */

get_header();
?>

<style>
.under-construction {
    min-height: 70vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 4rem 2rem;
    background: #edebde;
}

.under-construction__icon {
    font-size: 5rem;
    margin-bottom: 2rem;
    animation: bounce 2s infinite;
}

.under-construction__title {
    font-size: 3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
}

.under-construction__subtitle {
    font-size: 1.5rem;
    color: #4a5568;
    margin-bottom: 2rem;
}

.under-construction__description {
    font-size: 1.125rem;
    color: $color-gray-800;
    max-width: 600px;
    line-height: 1.6;
}

.under-construction__button {
    margin-top: 2rem;
    padding: 1rem 2rem;
    background-color: #313f31;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.under-construction__button:hover {
    background-color: #3182ce;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(66, 153, 225, 0.4);
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

@media (max-width: 768px) {
    .under-construction__title {
        font-size: 2rem;
    }
    
    .under-construction__subtitle {
        font-size: 1.25rem;
    }
    
    .under-construction__icon {
        font-size: 3.5rem;
    }
}
</style>

<section class="under-construction">
    <div class="under-construction__icon">🚧</div>
    <h1 class="under-construction__title">The page is under development</h1>
    <p class="under-construction__description">
    This page is currently under development. We are working hard
    to provide you with the best experience. Something interesting is coming soon!
    </p>
    <a href="<?php echo home_url('/'); ?>" class="under-construction__button">
    Go back to the main page
    </a>
</section>

<?php
get_footer();
