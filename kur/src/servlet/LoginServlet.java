package servlet;

import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import beans.Admin;
import beans.UserAccount;
import utils.DBUtils;
import utils.MyUtils;

@WebServlet(urlPatterns = { "/login" })
public class LoginServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    public LoginServlet() {
        super();
    }

    // Показать страницу Login.
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        // Forward (перенаправить) к странице /WEB-INF/views/loginView.jsp
        // (Пользователь не может прямо получить доступ
        // к страницам JSP расположенные в папке WEB-INF).
        RequestDispatcher dispatcher //
                = this.getServletContext().getRequestDispatcher("/WEB-INF/views/loginView.jsp");

        dispatcher.forward(request, response);

    }

    // Когда пользователь вводит userName & password, и нажимает Submit.
    // Этот метод будет выполнен.
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        String userName = request.getParameter("userName");
        String password = request.getParameter("password");
        String rememberMeStr = request.getParameter("rememberMe");
        boolean remember = "Y".equals(rememberMeStr);

        UserAccount user = null;
        Admin admin = null;
        boolean hasError = false;
        String errorString = null;

        if (userName.equals("") || password.equals("") || userName.length() == 0 || password.length() == 0) {
            hasError = true;
            errorString = "Required username and password!";
        } else {
            Connection conn = MyUtils.getStoredConnection(request);
            try {

                // Найти user или admin в DB.
                user = DBUtils.findUser(conn, userName, password);
                admin = DBUtils.findAdmin(conn,userName,password);
//                System.out.println(admin.getLogin() + " " + admin.getPassword());

                if (user == null && admin == null) {
                    hasError = true;
                    errorString = "User Name or password invalid";
                }

            } catch (SQLException e) {
                e.printStackTrace();
                hasError = true;
                errorString = e.getMessage();
            }
        }

        // В случае, если есть ошибка,
        // forward (перенаправить) к /WEB-INF/views/login.jsp
        if (hasError) {
            user = new UserAccount();
            user.setUserName(userName);
            user.setPassword(password);

            // Сохранить информацию в request attribute перед forward.
            request.setAttribute("errorString", errorString);

            // Forward (перенаправить) к странице /WEB-INF/views/login.jsp
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/loginView.jsp");

            dispatcher.forward(request, response);
        }

        // В случае, если нет ошибки.
        // Сохранить информацию пользователя в Session.
        // И перенаправить к странице userInfo.
        else {
            if(admin != null) {

                HttpSession session = request.getSession();
                MyUtils.storeLoginedAdmin(session, admin);

                // Если пользователь выбирает функцию "Remember me".
                if (remember) {
                    MyUtils.storeUserCookie(response, admin);
                }

                // Наоборот, удалить Cookie
                else {
                    MyUtils.deleteUserCookie(response);
                }

                // Redirect (Перенаправить) на страницу /userInfo.
                response.sendRedirect(request.getContextPath() + "/adminServlet");

            } else if(user != null) {

                HttpSession session = request.getSession();
                MyUtils.storeLoginedUser(session, user);

                // Если пользователь выбирает функцию "Remember me".
                if (remember) {
                    MyUtils.storeUserCookie(response, user);
                }
                // Наоборот, удалить Cookie
                else {
                    MyUtils.deleteUserCookie(response);
                }

                // Redirect (Перенаправить) на страницу /userInfo.
                response.sendRedirect(request.getContextPath() + "/userInfo");

            }
        }
    }

}