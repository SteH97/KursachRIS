package servlet;

import beans.Admin;
import beans.UserAccount;
import utils.MyUtils;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;

@WebServlet(urlPatterns = { "/adminServlet" })
public class AdminServlet extends HttpServlet{

    public AdminServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp)
            throws ServletException, IOException {
        HttpSession session = req.getSession();

        // Проверить, вошел ли пользователь в систему (login) или нет.
        Admin loginedAdmin = MyUtils.getLoginedAdmin(session);
        String adminTitle = loginedAdmin.getLogin();
        // Если еще не вошел в систему (login).
        if (loginedAdmin == null) {
            // Redirect (Перенаправить) к странице login.
            resp.sendRedirect(req.getContextPath() + "/login");
            return;
        }
        // Сохранить информацию в request attribute перед тем как forward (перенаправить).
        req.setAttribute("admin", adminTitle);

        // Если пользователь уже вошел в систему (login), то forward (перенаправить) к странице
        // /WEB-INF/views/userInfoView.jsp
        RequestDispatcher dispatcher //
                = this.getServletContext().getRequestDispatcher("/WEB-INF/views/adminView.jsp");
        dispatcher.forward(req, resp);
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        doGet(req, resp);
    }
}
