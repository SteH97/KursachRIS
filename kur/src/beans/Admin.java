package beans;

public class Admin {
    private String login;
    private String password;

    public Admin() {

    }

    public Admin(String login,String password){
        this.login = login;
        this.password = password;
    }

    public String getLogin() {
        return login;
    }

    public String getPassword() {
        return password;
    }
}
