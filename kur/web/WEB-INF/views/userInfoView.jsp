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

<h3>Hello: ${user}</h3>

User Name: <b>${user}</b>
<br />
Gender: ${user.gender } <br />

<jsp:include page="_footer.jsp"></jsp:include>

</body>
</html>
