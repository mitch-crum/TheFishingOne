<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
    <title>Register</title>
</head>

<body>
    <!-- Form Entry -->
    <form action="post">
        <fieldset>
            <legend>Name</legend>
            First:
            <input type="text" name="first">
            <br>Last:
            <input type="text" name="last">
            <br>
        </fieldset>
        <fieldset>
            <legend>Gender</legend>
            <input type="radio" name="gender" value="male">Male
            <input type="radio" name="gender" value="female">Female
            <input type="radio" name="gender" value="other">Other
        </fieldset>
        <fieldset>
            <legend>Date of Birth</legend>
            Month:
            <select name="month" size="1">
                <option selected="selected" value="">Select a Month</option>
                <option value="jan">January</option>
                <option value="feb">February</option>
                <option value="mar">March</option>
                <option value="apr">April</option>
                <option value="may">May</option>
                <option value="jun">June</option>
                <option value="jul">July</option>
                <option value="aug">August</option>
                <option value="sep">September</option>
                <option value="oct">October</option>
                <option value="nov">November</option>
                <option value="dec">December</option>
            </select>
            Year:
            <input type="text" name="year">
        </fieldset>
        <fieldset>
            <legend>Address</legend>
            Street Address:
            <input type="text" name="line1">
            <br>Line 2:
            <input type="text" name="line2">
            <br>City:
            <input type="text" name="city">
            <br>State:
            <select name="state">
                <option value="" selected="selected">Select a State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
            Zipcode:
            <input type="text" name="zip">
            <br>
        </fieldset>
        <fieldset>
            <legend>Email</legend>
            Email:
            <input type="text" name="email1">
            <br>Verify Email:
            <input type="text" name="email2">
            <br>
        </fieldset>
        <fieldset>
            <legend>User</legend>
            Desired Username:
            <input type="text" name="username">
            <br>Password:
            <input type="text" name="password1">
            <br>Verify Password:
            <input type="text" name="password2">
            <br>
        </fieldset>
    </form>
</body>

</html>