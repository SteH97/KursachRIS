package servlet;

import beans.Admin;
import beans.UserAccount;
import utils.DBUtils;
import utils.MyUtils;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;

@WebServlet(urlPatterns = { "/registration" })
public class RegistrationServlet extends HttpServlet {

    public RegistrationServlet() {
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
                = this.getServletContext().getRequestDispatcher("/WEB-INF/views/registrationView.jsp");

        dispatcher.forward(request, response);

    }

    // Когда пользователь вводит userName & password, и нажимает Submit.
    // Этот метод будет выполнен.
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        String login = request.getParameter("login");
        String clientName = request.getParameter("clientName");
        String clientSurname = request.getParameter("clientSurname");
        String clientEmail = request.getParameter("clientEmail");
        String clientTelephone = request.getParameter("clientTelephone");
        String password = request.getParameter("password");
        String passwordRepeat = request.getParameter("passwordRepeat");

        boolean hasError = false;
        String errorString = null;

        if (login.equals("" ) || clientName.equals("") || clientSurname.equals("") || clientEmail.equals("") || clientTelephone.equals("")
                || !password.equals(passwordRepeat))
        {
            hasError = true;
            errorString = "Ошибка добавления данных";
        } else {
            Connection conn = MyUtils.getStoredConnection(request);
            try {
                DBUtils.insertClient(conn,login,password,clientName,clientSurname,clientEmail,clientTelephone);
            } catch (SQLException e) {
                e.printStackTrace();
                hasError = true;
                errorString = e.getMessage();
            }
        }

        if(hasError){
            // Сохранить информацию в request attribute перед forward.
            request.setAttribute("errorString", errorString);

            // Forward (перенаправить) к странице /WEB-INF/views/login.jsp
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/registrationView.jsp");

            dispatcher.forward(request, response);
        }
        // В случае, если нет ошибки.
        // Сохранить информацию пользователя в Session.
        // И перенаправить к странице userInfo.
        else {
            UserAccount user = new UserAccount(login,password);

            HttpSession session = request.getSession();
            MyUtils.storeLoginedUser(session, user);

            // Redirect (Перенаправить) на страницу /userInfo.
            response.sendRedirect(request.getContextPath() + "/userInfo");
        }
    }
}
