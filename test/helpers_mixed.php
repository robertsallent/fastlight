<main>
    <h1>Test de varios helpers</h1>
    
    <section>
        <h2>Test del helper request()</h2>
        <p>Retorna la Request actual.</p>
        
        <?php dump(request()) ?>
    </section>
    
    
    <section>
        <h2>Helper user()</h2>
        <p>Retorna el usuario identificado.</p>
        <?php dump(user()) ?>
    </section>
</main>