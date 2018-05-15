package beans;

public class Orders {
    private int id_order;
    private int id_product;
    private String login;
    private String status;
    private int quantity;

    public Orders(){

    }

    public Orders(int id_order,String status){
        this.id_order = id_order;
        this.status = status;
    }

    public Orders(int id_product,int quantity){
        this.id_product = id_product;
        this.quantity = quantity;
    }
}
