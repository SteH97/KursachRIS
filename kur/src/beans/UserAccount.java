package beans;

public class UserAccount {
    public static final String GENDER_MALE ="M";
    public static final String GENDER_FEMALE = "F";

    private String login;
    private String gender;
    private String password;


    public UserAccount() {

    }

    public UserAccount(String login,String password){
        this.login = login;
        this.password = password;
    }

    public String getUserName() {
        return login;
    }

    public void setUserName(String userName) {
        this.login = userName;
    }

    public String getGender() {
        return gender;
    }

    public void setGender(String gender) {
        this.gender = gender;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }
}
