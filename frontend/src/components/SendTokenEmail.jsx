import React, { useState, useEffect } from "react";
import emailjs from 'emailjs-com';
import axios from "axios";

const SendTokenEmail = () => {
    const [email, setEmail] = useState("");

    const handleEmailChange = (e) => {
        setEmail(e.target.value);
    }

    const getResetToken = async () => {
        try {
            const response = await axios.post('/api/get-token', { email });
            return response.data.token;
        } catch (error) {
            console.error('Error getting reset token:', error);
            throw error;
        }
    }

    const sendEmail = async (e) => {
        e.preventDefault();
        try {
            const resetToken = await getResetToken();
            const serviceID = "service_lh8yepw";
            const templateID = "template_k43898j";
            const resetLink = `${window.location.origin}/password-reset/${resetToken}`;
            const props = {
                email: email,
                message: resetLink,
            };
            await emailjs.send(serviceID, templateID, props);
            alert("Email sent successfully!!");
        } catch (error) {
            console.error('Error sending email:', error);
        }
    };

    useEffect(() => {
        emailjs.init("ejlOnc03qO1AQW365");
    }, []);

    return (
        <div>
            <form onSubmit={sendEmail}>
                <input type="email" onChange={handleEmailChange} placeholder="Enter your email" required />
                <button type="submit">Send</button>
            </form>
        </div>
    );
}

export default SendTokenEmail;
