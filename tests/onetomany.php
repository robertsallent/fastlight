<?php
    echo "<h1>Test de relaciones 1 a N</h1>";

    echo "<h2>Pruebas hasMany() y belongsTo().</h2>";
    
    class Customer extends Model{};
    class Product extends Model{};
    class Sale extends Model{};
    
    
    echo "<h3>Todas las ventas al cliente 1:</h3>";
    dump(Customer::find(1)->hasMany('Sale'));
    
    echo "<h3>Todas las ventas del producto 3:</h3>";
    dump(Product::find(3)->hasMany('Sale'));
    
    echo "<h3>Cliente de la venta 1:</h3>";
    dump(Sale::find(1)->belongsTo('Customer'));
    
    echo "<h3>Cliente de la primera venta del producto 1</h3>";
    dump(Product::find(1)->hasMany('Sale')[0]->belongsTo('Customer'));
    
    