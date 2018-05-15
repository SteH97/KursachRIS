package servlet;

import beans.Clients;
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

@WebServlet(urlPatterns = { "/editProfile" })
public class EditProfileServlet extends HttpServlet{
    private static final long serialVersionUID = 1L;

    public EditProfileServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        HttpSession session = request.getSession();
        Connection conn = MyUtils.getStoredConnection(request);
        // Проверить, вошел ли пользователь в систему (login) или нет.
        UserAccount loginedUser = MyUtils.getLoginedUser(session);

        // Если еще не вошел в систему (login).
        if (loginedUser == null) {
            // Redirect (Перенаправить) к странице login.
            response.sendRedirect(request.getContextPath() + "/login");
            return;
        } else if(loginedUser != null) {
            // Сохранить информацию в request attribute перед тем как forward (перенаправить).
            request.setAttribute("typeOperationUser","edit");
            request.setAttribute("user", loginedUser);
            request.setAttribute("nameHeader","Редактирование профиля");

            Clients client = DBUtils.queryClient(conn,loginedUser.getUserName());

            request.setAttribute("client",client);
            request.setAttribute("inputUser","Редактировать");

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
