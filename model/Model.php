<?php

// Clase padre para todos los modelos
// implementa las operaciones genéricas del CRUD y el __toString()
// también dispone de métodos para recuperar las entidades relacionadas 1 a N

// Automatiza las tareas del CRUD, permitiendo que los modelos estén vacíos

// autor: Robert Sallent
// última revisión: 13/09/2022

class Model{
  
    // método para recuperar un array con todos los objetos.
    public static function get():array{
        // calcula el nombre de la tabla (Libro --> libros)
        // ojo, que el modelo Ejemplar deberá llamarse Ejemplare
        $tabla = strtolower(get_called_class()).'s';
        
        // prepara la consulta y la ejecuta
        $consulta = "SELECT * FROM $tabla";
        return DB::selectAll($consulta, get_called_class()); 
    }

    // método para recuperar un objeto a partir de su ID (null si no lo encuentra)
    public static function getById(int $id){
        // calcula el nombre de la tabla (Libro --> libros)
        $tabla = strtolower(get_called_class()).'s';
        
        $consulta = "SELECT * FROM $tabla WHERE id=$id";
        return DB::select($consulta, get_called_class());
    }
    
    // método para guardar un nuevo objeto en la BDD    
    public function guardar(){
        $tabla = strtolower(get_called_class()).'s'; // nombre de la tabla
        
        // prepara la consulta de inserción (esta es más compleja)
        $consulta="INSERT INTO $tabla (";
        
        // nombres de los campos
        foreach($this as $propiedad=>$valor) 
            $consulta .= "$propiedad, ";        
        
        $consulta = rtrim($consulta, ', '); // quita la última coma
        $consulta .= ") VALUES (";
        
        // valores
        foreach($this as $valor)
            // pone comillas en el SQL solo para los string
            // también controla los valores nulos
            switch(gettype($valor)){
                case "string" : $consulta .= "'$valor', "; break;
                case "NULL"   : $consulta .= "NULL, "; break;
                default       : $consulta .= "$valor, ";
            }   

        $consulta = rtrim($consulta, ', '); // quita la última coma
        $consulta .= ")";
        
        $this->id = DB::insert($consulta); // guarda el nuevo objeto 
           
        // retorna el id del nuevo objeto (o false si falló la inserción)
        return $this->id;      
    } 
    
    // método que actualiza un objeto en la base de datos
    public function actualizar(){ 
        $tabla = strtolower(get_called_class()).'s'; // nombre de la tabla
        
        // prepara la consulta 
        $consulta="UPDATE $tabla SET ";
        
        // pone comillas en el SQL solo para los string
        foreach($this as $propiedad=>$valor)
            switch(gettype($valor)){
                case "string" : $consulta .= "$propiedad='$valor', "; break;
                case "NULL"   : $consulta .= "$propiedad=NULL, "; break;
                default       : $consulta .= "$propiedad=$valor, "; 
            }
                    
        $consulta = rtrim($consulta, ', '); // quita la última coma
        $consulta .= " WHERE id=$this->id";

        // lanza la consulta y retorna el número de filas afectadas
        // o false si hubo algún problema
        return DB::update($consulta); 
    }
    
    // recuperar objetos con un filtro avanzado
    public static function getFiltered(string $campo='id', string $valor='',
        string $orden='id', string $sentido='ASC'):array{
        
            $tabla = strtolower(get_called_class()).'s'; // nombre de la tabla
            
            $consulta="SELECT *
               FROM $tabla
               WHERE $campo LIKE '%$valor%'
               ORDER BY $orden $sentido";
            
            return DB::selectAll($consulta, get_called_class());
    }
    
    // método que borra un objeto de la base de datos
    public static function borrar(int $id){
        $tabla = strtolower(get_called_class()).'s'; // nombre de la tabla  
        $consulta="DELETE FROM $tabla WHERE id=$id";  
        return DB::delete($consulta);
    }
    
    // método que realiza consultas de totales
    public static function total(
        string $operacion = 'COUNT',
        string $campo = '*'
    ){
        $tabla = strtolower(get_called_class()).'s'; // nombre de la tabla
        return DB::total($tabla, $operacion, $campo);
    }
    
    
    
    // método que recupera objetos relacionados en relación 1 a N
    // $propietario->hasMany(string $entidad, string $foranea, string $local):array
    
    // por ejemplo para recuperar préstamos de un socio sería: 
    // $socio->hasMany('Prestamo', 'idsocio', 'id')
    
    // - si la clave foranea respeta el nombre 'id' + entidad, no hace falta indicarla
    // - si la clave local (primaria) se llama 'id', no hace falta indicarla 
    // el ejemplo anterior también funcionará como $socio->hasMany('Prestamo');
    
    public function hasMany(
        string $related,            // clase (entidad) relacionada
        string $foreignKey = null,  // clave foránea
        string $localKey = 'id'     // clave local
    ):array{       
        $tabla = strtolower($related).'s';   // cálculo del nombre de la tabla
        $foreignKey = $foreignKey ?? 'id'.strtolower(get_called_class());  // cálculo foranea
        
        $consulta = "SELECT * FROM $tabla WHERE $foreignKey = ".$this->$localKey; // consulta
        return DB::selectAll($consulta, $related);
    }
    
    
    // método que recupera objetos relacionados en relación 1 a N de forma inversa
    
    // por ejemplo para recuperar el socio de un préstamo sería 
    // $prestamo->belongsTo('Socio', 'idsocio', 'id')
    
    // - si la clave foranea respeta el nombre 'id' + entidad, no hace falta indicarla 
    // - si la clave del propietario se llama 'id', no hace falta indicarla
    // el ejemplo anterior también funciona como $prestamo->belongsTo('Socio');
    
    public function belongsTo(
        string $related, 
        string $foreignKey = null,
        string $ownerKey = 'id'
    ){
        $tabla = strtolower($related).'s';                       // nombre de la tabla
        $foreignKey = $foreignKey ?? 'id'.strtolower($related);  // cálculo  foranea
        
        $consulta="SELECT * FROM $tabla WHERE $ownerKey = ".$this->$foreignKey;
        return DB::select($consulta, $related);
    }
    
    
    
    // el método __toString(), lo usaremos principalmente en test
    public function __toString():string{
        $texto = '';
       
        foreach($this as $propiedad=>$valor)
            $texto .= "$propiedad: <b>$valor</b>, ";
        
        return rtrim($texto, ', '); // quita la última coma
    }
}


