import React from 'react';
import Header from '../Components/Frontend/Header';
import Footer from '../Components/Frontend/Footer';

const FrontendLayout = ({ children }) => {
    return (
        <div className="min-h-screen bg-gray-50 flex flex-col">
            <Header />
            <main className="flex-1">
                {children}
            </main>
            <Footer />
        </div>
    );
};

export default FrontendLayout;