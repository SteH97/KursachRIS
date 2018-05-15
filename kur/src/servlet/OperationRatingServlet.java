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
import java.sql.SQLException;

@WebServlet(urlPatterns = { "/operationRating" })
public class OperationRatingServlet extends HttpServlet{

    OperationRatingServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {

    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        Connection conn = MyUtils.getStoredConnection(req);
        HttpSession session = req.getSession();

        UserAccount loginedUser = MyUtils.getLoginedUser(session);
        String name = req.getParameter("userNameEdit");

        String errorString = null;


        // Сохранить информацию в request attribute перед тем как forward к views.
        req.setAttribute("errorString", errorString);

        // Если имеется ошибка forward (перенаправления) к странице 'edit'.
        if (errorString != null) {
            req.setAttribute("typeOperationUser","rating");
            RequestDispatcher dispatcher = req.getServletContext()
                    .getRequestDispatcher("/WEB-INF/views/userInfoView.jsp");
            dispatcher.forward(req, resp);
        } else {
            req.setAttribute("user", loginedUser);
            req.setAttribute("nameHeader","Персональные данные");
            Clients client = DBUtils.queryClient(conn,loginedUser.getUserName());
            req.setAttribute("client",client);
            req.setAttribute("typeOperationUser","personalData");
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/userInfoView.jsp");
            dispatcher.forward(req, resp);
        }
    }
}
