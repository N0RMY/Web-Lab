package com.example.demo;

public class ContactForm {
    private String name;
    private String email;
    private String phone;
    private String message;

    public String getName() { return this.name; }
    public void setName(String name) { this.name = name; }

    public String getEmail() { return this.email; }
    public void setEmail(String email) { this.email = email; }

    public String getPhone() { return this.phone; }
    public void setPhone(String phone) { this.phone = phone; }

    public String getMessage() { return this.message; }
    public void setMessage(String message) { this.message = message; }

    @Override
    public String toString() {
        return "ContactForm{name='" + name + "', email='" + email + "', phone='" + phone + "', message='" + message + "'}";
    }
}
