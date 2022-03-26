<p>Forum Built using Laravel, Inertia.js and Vue.js 3</p>

<p>This forum is a refactoring of my university forum which was built with vanilla php and vanilla js.</p>

<p>The forum features:</p>
    <ul>
        <li>Sign up/Login system</li>
        <li>Creating and updating posts</li>
        <li>Creating and updating comments</li>
        <li>Updating user data including profile and banner images</li>
        <li>Able to delete your account</li>
        <li>SweetAlert2 Modal notifications</li>
        <li>Real time message system</li>
        <li>The forum also features the standard laravel OOP design with the standard Laravel protections such as; CSRF tokens, request data validations as well as authorisation checks</li>
    </ul>
<p>How to run the project:</p>
    <ol>
        <li>Configure .env.example to a .env file with your database configurations and the app URL tag (this is important due to the images on the site using the full url pathway)</li>
        <li>Run the database migrations, e.g, php artisan migrate</li>
        <li>Run the database seeders, e.g, php db:seed</li>
        <li>Compile webpack assets, e.g, npm run dev or npm run production</li>
        <li>Link the storage file ot the public root directory, e.g, php artisan storage:link</li>
        <li>Serve the website, e.g, php artisan serve</li>
    </ol>
