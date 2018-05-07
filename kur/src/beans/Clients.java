package beans;

public class Clients {
    private int id_client;
    private String name;
    private String surname;
    private String email;
    private String telephone;

    public Clients(){

    }

    public Clients(String name,String surname,String email,String telephone){
        this.name = name;
        this.surname = surname;
        this.email = email;
        this.telephone = telephone;
    }

    public int getId_client() {
        return id_client;
    }

    public String getName() {
        return name;
    }

    public String getSurname() {
        return surname;
    }

    public String getEmail() {
        return email;
    }

    public String getTelephone() {
        return telephone;
    }
}
