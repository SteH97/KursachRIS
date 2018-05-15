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

@WebServlet(urlPatterns = { "/operationEdit" })
public class OperationEditProfileServlet extends HttpServlet{
    public OperationEditProfileServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        Connection conn = MyUtils.getStoredConnection(request);
        HttpSession session = request.getSession();

        UserAccount loginedUser = MyUtils.getLoginedUser(session);
        String name = request.getParameter("userNameEdit");
        String surname = request.getParameter("userSurnameEdit");
        String email = request.getParameter("userEmailEdit");
        String telephone = request.getParameter("userTelephoneEdit");

        String errorString = null;

        if(name.equals("") || surname.equals("") || email.equals("") || telephone.equals("")) {
            errorString = "Ошибка в поле";
        }

        if (errorString == null) {
            try {
                DBUtils.updateClient(conn,loginedUser.getUserName(), name,surname,email,telephone);
            } catch (SQLException e) {
                e.printStackTrace();
                errorString = e.getMessage();
            }
        }

        // Сохранить информацию в request attribute перед тем как forward к views.
        request.setAttribute("errorString", errorString);

        // Если имеется ошибка forward (перенаправления) к странице 'edit'.
        if (errorString != null) {
            request.setAttribute("typeOperationUser","edit");
            RequestDispatcher dispatcher = request.getServletContext()
                    .getRequestDispatcher("/WEB-INF/views/userInfoView.jsp");
            dispatcher.forward(request, response);
        } else {
            request.setAttribute("user", loginedUser);
            request.setAttribute("nameHeader","Персональные данные");
            Clients client = DBUtils.queryClient(conn,loginedUser.getUserName());
            request.setAttribute("client",client);
            request.setAttribute("typeOperationUser","personalData");
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/userInfoView.jsp");
            dispatcher.forward(request, response);
        }
    }
}
