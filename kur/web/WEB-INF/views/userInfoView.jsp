<%--
  Created by IntelliJ IDEA.
  User: Кирилл
  Date: 25.04.2018
  Time: 18:59
  To change this template use File | Settings | File Templates.
--%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
         pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Info</title>
</head>
<body>

<jsp:include page="_header.jsp"></jsp:include>
<jsp:include page="_menu.jsp"></jsp:include>

<div>
    <label>Здравствуйте</label>
    <p> ${user.getUserName()}</p>
    <label>Имя</label>
    <p>${client.getName()}</p>
    <label>Фамилия</label>
    <p>${client.getSurname()}</p>
    <label>Почта</label>
    <p>${client.getEmail()}</p>
    <label>Телефон</label>
    <p>${client.getTelephone()}</p>
</div>

<%--
<h3>Hello: ${user.getUserName()}</h3>

User Name: <b>${user.getUserName()}</b>
--%>
<jsp:include page="_footer.jsp"></jsp:include>

</body>
</html>
