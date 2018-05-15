<%--
  Created by IntelliJ IDEA.
  User: Alex SteH
  Date: 12.05.2018
  Time: 20:18
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>
<h3>Регистрация</h3>
<p style="color: red;">${errorString}</p>

<form method="POST" action="${pageContext.request.contextPath}/registration">
    <table border="0">
        <tr>
            <td>Логин</td>
            <td><input type="text" name="login" /> </td>
        </tr>
        <tr>
            <td>Имя</td>
            <td><input type="text" name="clientName"/> </td>
        </tr>
        <tr>
            <td>Фамилия</td>
            <td><input type="text" name="clientSurname"/> </td>
        </tr>
        <tr>
            <td>Почта</td>
            <td><input type="text" name="clientEmail"/> </td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type="text" name="clientTelephone"/> </td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td><input type="password" name="password"/> </td>
        </tr>
        <tr>
            <td>Повторите пароль</td>
            <td><input type="password" name="passwordRepeat"/> </td>
        </tr>
        <tr>
            <td colspan ="2">
                <input type="submit" value= "Submit" />
                <a href="${pageContext.request.contextPath}/">Cancel</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
