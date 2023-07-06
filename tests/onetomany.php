<?php
    echo "<h1>Test de relaciones 1 a N</h1>";
    
    class Customer extends Model{};
    class Product extends Model{};
    class Sale extends Model{};
    
    echo "<h2>Pruebas de hasAny().</h2>";
    echo Customer::find(1)->hasAny('Sale') ? 
            "<p>El cliente 1 ha comprado cosas.</p>":
            "<p>El cliente 1 no ha comprado cosas.</p>";

    echo Customer::find(6)->hasAny('Sale') ?
            "<p>El cliente 6 ha comprado cosas.</p>":
            "<p>El cliente 6 no ha comprado cosas.</p>";
    
    
    echo "<h2>Pruebas de belongsToAny().</h2>";
    echo Sale::find(1)->belongsToAny('Customer') ?
        "<p>Conocemos el cliente de la venta 1.</p>":
        "<p>No conocemos el cliente de la venta 1.</p>";
    
    
    echo "<h2>Pruebas hasMany() y belongsTo().</h2>";

    
    echo "<h3>Todas las ventas al cliente 1:</h3>";
    dump(Customer::find(1)->hasMany('Sale'));
    
    echo "<h3>Todas las ventas del producto 3:</h3>";
    dump(Product::find(3)->hasMany('Sale'));
    
    echo "<h3>Cliente de la venta 1:</h3>";
    dump(Sale::find(1)->belongsTo('Customer'));
    
    echo "<h3>Cliente de la primera venta del producto 1</h3>";
    dump(Product::find(1)->hasMany('Sale')[0]->belongsTo('Customer'));
    
    