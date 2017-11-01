<?php
require_once("Mysql.php");
class Product extends Mysql
{
	// Les attributs priv�s
	private $_id;
    private $_libelle;
    private $_Prix;
    private $_catag ;
	private $_description;
	private $_image;

	// M�thode magique pour les setters & getters
	public function __get($attribut) {
		if (property_exists($this, $attribut)) 
                return ( $this->$attribut ); 
        else
			exit("Erreur dans la calsse " . __CLASS__ . " : l'attribut $attribut n'existe pas!");     
    }

    public function __set($attribut, $value) {
        if (property_exists($this, $attribut)) {
            $this->$attribut = (mysqli_real_escape_string($this->get_cnx(), $value)) ;
        }
        else
        	exit("Erreur dans la calsse " . __CLASS__ . " : l'attribut $attribut n'existe pas!");
    }

	public function details($id)
	{
		$q = "SELECT * FROM produit WHERE id ='$id'";
		$res = $this->requete($q);
		$row = mysqli_fetch_array( $res); 
		$prod = new Product();
		
		$prod->_id 			= $row['id'];
        $prod->_libelle 		= $row['libelle'];
        $prod->_Prix		= $row['prix'];
        $prod->_categ =$row['id_categorie'];
		$prod->_image 		= $row['image'];
		$prod->_description	= $row['description'];
	
		return $cat;
	}


	public function liste()
	{
		$q = "SELECT * FROM produit ORDER BY libelle";
		$list_prod = array(); // Tableau VIDE
		$res = $this->requete($q);
		while($row = mysqli_fetch_array( $res)){
			$prod = new Product();

			$prod->_id 			= $row['id'];
			$prod->_libelle 		= $row['libelle'];
			$prod->_Prix		= $row['prix'];
			$prod->_categ =$row['id_categorie'];
			$prod->_image 		= $row['image'];
			$prod->_description	= $row['description'];;
		
			$list_prod[]=$prod;
		}
		
		return $list_prod;
	}
	
	public function ajouter()
	{
	    $q = "INSERT INTO produit(id, libelle,description,prix,image,id_categorie) VALUES 
	  		(  null				, '$this->_libelle','$this->_description','$this->_Prix'	
			  '$this->_image'	, '$this->_categ'	
			)";
		$res = $this->requete($q);
		return mysqli_insert_id($this->get_cnx());
	}
	
	public function modifier(){
		$q = "UPDATE produit SET
			  libelle 	= '$this->_libelle',
			  description = '$this->_description',
			  prix=''$this->_Prix'',
			  image = IF('$this->_image' = '', image, '$this->_image',
			  id_categorie='$this->_categ') ,
			  

			  WHERE id = '$this->_id' ";
	  
		$res = $this->requete($q);
		return $res;
	}

	public function supprimer($id){
		$q = "DELETE FROM produit WHERE id = '$id'";
		$res = $this->requete($q);
		return $res;
	}	 
}
?>