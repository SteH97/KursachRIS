package servlet;

import java.io.IOException;
import java.sql.Connection;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import beans.Clients;
import beans.UserAccount;
import conn.MySQLConnUtils;
import utils.DBUtils;
import utils.MyUtils;

@WebServlet(urlPatterns = { "/userInfo" })
public class UserInfoServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    public UserInfoServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        HttpSession session = request.getSession();

        // Проверить, вошел ли пользователь в систему (login) или нет.
        UserAccount loginedUser = MyUtils.getLoginedUser(session);
        Connection conn = MyUtils.getStoredConnection(request);
        // Если еще не вошел в систему (login).
        if (loginedUser == null) {
            // Redirect (Перенаправить) к странице login.
            response.sendRedirect(request.getContextPath() + "/login");
            return;
        } else if(loginedUser != null) {
            // Сохранить информацию в request attribute перед тем как forward (перенаправить).
            request.setAttribute("user", loginedUser);
            Clients client = DBUtils.queryClient(conn,loginedUser.getUserName());
            request.setAttribute("client",client);
            request.setAttribute("nameHeader","Персональные данные");
            request.setAttribute("typeOperationUser","personalData");

            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/userInfoView.jsp");
            dispatcher.forward(request, response);
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        doGet(request, response);
    }

}
