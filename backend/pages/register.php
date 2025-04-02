
<div class="container">
    <h2>Register</h2>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"> <?php echo $error; ?> </div>
    <?php endif; ?>
    
    <form method="POST" action="index.php?page=register">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                placeholder="Enter email" 
                required
            >
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control" 
                placeholder="Enter password" 
                required
            >
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
