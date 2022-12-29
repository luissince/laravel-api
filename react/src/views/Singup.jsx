import { createRef, useState } from "react";
import { Link } from "react-router-dom";
import { useStateContext } from "../context/ContextProvider";
import axiosClient from '../axios-client';

export default function Singup() {

    const [load, setLoad] = useState(false);

    const nameRef = createRef();
    const emailRef = createRef();
    const passwordRef = createRef();
    const passwordConfirmationRef = createRef();

    const { setUser, setToken } = useStateContext();
    const [errors, setErrors] = useState(null);

    const onSubmit = async (ev) =>  {
        ev.preventDefault();
        setLoad(true);
        setErrors(null);

        const payload = {
            name: nameRef.current.value,
            email: emailRef.current.value,
            password: passwordRef.current.value,
            password_confirmation: passwordConfirmationRef.current.value,
        }

        try {
            const {data} = await axiosClient.post('/signup', payload);
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
            <h1 className="title">Signup for free</h1>
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
            <input ref={nameRef} type="text" placeholder="Full Name" />
            <input ref={emailRef} type="email" placeholder="Email Address" />
            <input ref={passwordRef} type="password" placeholder="Password" />
            <input ref={passwordConfirmationRef} type="password" placeholder="Password Confirmation" />
            <button className="btn btn-lock">
                Signup
            </button>
            <p className="message">
                Already Register? <Link to="/login">Sign in</Link>
            </p>
        </form>
    );
}