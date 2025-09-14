import React from 'react';
import { Link, usePage } from '@inertiajs/react';

const Header = () => {
    const { auth } = usePage().props;
    const isAuthenticated = auth && auth.user;

    return (
        <header className="bg-white shadow-lg">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center py-6">
                    <Link href="/" className="text-2xl font-bold text-indigo-600">
                        Hotel Paradise
                    </Link>
                    <nav className="hidden md:flex space-x-8">
                        <Link href="/" className="text-gray-700 hover:text-indigo-600">Home</Link>
                        <Link href="/rooms" className="text-gray-700 hover:text-indigo-600">Rooms</Link>
                        <Link href="/about" className="text-gray-700 hover:text-indigo-600">About</Link>
                        <Link href="/contact" className="text-gray-700 hover:text-indigo-600">Contact</Link>
                    </nav>
                    <div className="flex items-center space-x-4">
                        {isAuthenticated ? (
                            <Link 
                                href={route('admin.index')} 
                                className="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <a 
                                href={route('login')} 
                                target="_blank"
                                className="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300"
                            >
                                Login
                            </a>
                        )}
                    </div>
                </div>
            </div>
        </header>
    );
};

export default Header;