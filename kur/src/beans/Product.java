package beans;

public class Product {

    private int id_product;
    private String type;
    private String brand;
    private String name_pr;
    private int quantity;
    private int rating;
    private float cost;

    public Product() {

    }

    public Product(int quantity,float cost) {
        this.quantity = quantity;
        this.cost = cost;
    }

    public Product(String type, String brand,String name_pr,int quantity,float cost) {
        this.type = type;
        this.brand = brand;
        this.name_pr = name_pr;
        this.quantity = quantity;
        this.cost = cost;
    }

    public Product(int id_product,String type, String brand,String name_pr,int quantity,int rating,float cost) {
        this.id_product = id_product;
        this.type = type;
        this.brand = brand;
        this.name_pr = name_pr;
        this.quantity = quantity;
        this.rating = rating;
        this.cost = cost;
    }

    ////////////////////////////////////////////////////////////
    // Set

    public void setId_product(int id_product) {
        this.id_product = id_product;
    }

    public void setType(String type) {
        this.type = type;
    }

    public void setBrand(String brand) {
        this.brand = brand;
    }

    public void setName_pr(String name_pr) {
        this.name_pr = name_pr;
    }

    public void setQuantity(int quantity) {
        this.quantity = quantity;
    }

    public void setRating(int rating) {
        this.rating = rating;
    }

    public void setCost(float cost) {
        this.cost = cost;
    }

    /////////////////////////////////////////////////
    // Get

    public int getId_product() {
        return id_product;
    }

    public String getType() {
        return type;
    }

    public String getBrand() {
        return brand;
    }

    public String getName_pr() {
        return name_pr;
    }

    public int getQuantity() {
        return quantity;
    }

    public int getRating() {
        return rating;
    }

    public float getCost() {
        return cost;
    }
}