import { createRef, useState } from "react";
import { Link } from "react-router-dom";
import { useStateContext } from "../context/ContextProvider";
import axiosClient from '../axios-client';

export default function Login() {

    const [load, setLoad] = useState(false);

    const emailRef = createRef();
    const passwordRef = createRef();

    const { setUser, setToken } = useStateContext();
    const [errors, setErrors] = useState(null);

    const onSubmit = async (ev) => {
        ev.preventDefault();
        setLoad(true);
        setErrors(null);

        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value,
        }

        try {
            const { data } = await axiosClient.post('/login', payload)
            setUser(data.user);
            setToken(data.token);
        } catch (error) {
            setLoad(false);
            const response = error.response;
            if (response && response.status == 422) {
                setErrors(response.data.errors)
            }
        }
    }

    return (
        <form onSubmit={onSubmit}>
            <h1 className="title">Login into your account</h1>
            {
                errors && <div className="alert">
                    {Object.keys(errors).map(key => (
                        <p key={key}>{errors[key][0]}</p>
                    ))}
                </div>
            }
               {
                load &&
                <div className="loader-content">
                    <div className="loader"></div>
                </div>
            }
            <input ref={emailRef} type="email" placeholder="Email" />
            <input ref={passwordRef} type="password" placeholder="Password" />
            <button className="btn btn-lock">
                Login
            </button>
            <p className="message">
                Not Registered? <Link to="/singup">Create an account</Link>
            </p>
        </form>
    );
}