import { Navigate, createBrowserRouter } from 'react-router-dom';
import Login from './views/Login';
import Singup from './views/Singup';
import Users from './views/users';
import UserForm from "./views/UserForm";
import NotFound from './views/NotFound';
import DefautLayout from './components/DefaultLayout';
import GuestLayout from './components/GuestLayout';
import Dashboard from './views/Dashboard';

const router = createBrowserRouter([
    {
        path: '/',
        element: <DefautLayout />,
        children: [
            {
                path: '/',
                element: <Navigate to="/users" />
            }
            ,
            {
                path: '/dashboard',
                element: <Dashboard />
            },,
            {
                path: '/users',
                element: <Users />
            },
            {
              path: '/users/new',
              element: <UserForm key="userCreate" />
            },
            {
              path: '/users/:id',
              element: <UserForm key="userUpdate" />
            }
        ]
    },
    {
        path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/login',
                element: <Login />
            },
            {
                path: '/singup',
                element: <Singup />
            },
        ]
    },
    {
        path: '*',
        element: <NotFound />
    },
]);

export default router;