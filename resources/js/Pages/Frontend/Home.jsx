import React from 'react';
import FrontendLayout from '../../Layouts/FrontendLayout';
import SearchForm from '../../Components/Frontend/SearchForm';
import RoomGrid from '../../Components/Frontend/RoomGrid';
import { Head } from '@inertiajs/react';

const Home = ({ featuredRooms }) => {
    return (
        <FrontendLayout>
            <Head>
                <title>Hotel Paradise - Luxury Accommodations</title>
                <meta name="description" content="Experience luxury and comfort at Hotel Paradise. Book your stay today for the best rates and amenities." />
            </Head>

            {/* Hero Section */}
<section className="relative h-96 bg-cover bg-center" style={{ 
    backgroundImage: 'url(/images/hotel-hero.jpg)',
    backgroundImage: 'url(https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80)'
}}>
                <div className="absolute inset-0 bg-black bg-opacity-50"></div>
                <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                    <div className="text-white">
                        <h1 className="text-4xl md:text-5xl font-bold mb-4">Welcome to Hotel Paradise</h1>
                        <p className="text-lg md:text-xl mb-8">Experience luxury and comfort like never before</p>
                        <button className="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold">
                            Book Your Stay
                        </button>
                    </div>
                </div>
            </section>

            {/* Search Form */}
            <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
                <SearchForm />
            </section>

            {/* Featured Rooms */}
            <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div className="text-center mb-12">
                    <h2 className="text-3xl font-bold text-gray-800 mb-4">Featured Rooms</h2>
                    <p className="text-gray-600">Discover our most popular accommodations</p>
                </div>
                
                <RoomGrid rooms={featuredRooms} />
                
                <div className="text-center mt-12">
                    <a
                        href={route('rooms.index')}
                        className="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition duration-300 font-semibold"
                    >
                        View All Rooms
                    </a>
                </div>
            </section>

            {/* Features Section */}
            <section className="bg-gray-100 py-16">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div className="text-center">
                            <div className="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">🏨</span>
                            </div>
                            <h3 className="text-xl font-semibold mb-2">Luxurious Rooms</h3>
                            <p className="text-gray-600">Elegant accommodations with modern amenities</p>
                        </div>
                        <div className="text-center">
                            <div className="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">⭐</span>
                            </div>
                            <h3 className="text-xl font-semibold mb-2">5-Star Service</h3>
                            <p className="text-gray-600">Exceptional service from our dedicated staff</p>
                        </div>
                        <div className="text-center">
                            <div className="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span className="text-2xl">📍</span>
                            </div>
                            <h3 className="text-xl font-semibold mb-2">Prime Location</h3>
                            <p className="text-gray-600">Centrally located with easy access to attractions</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Testimonials Section */}
            <section className="py-16 bg-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-12">
                        <h2 className="text-3xl font-bold text-gray-800 mb-4">What Our Guests Say</h2>
                        <p className="text-gray-600">Don't just take our word for it</p>
                    </div>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div className="bg-gray-50 p-6 rounded-lg">
                            <div className="flex items-center mb-4">
                                <div className="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                    <span className="text-lg">👤</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold">John Doe</h4>
                                    <p className="text-gray-600 text-sm">Business Traveler</p>
                                </div>
                            </div>
                            <p className="text-gray-700">"The rooms are spacious and the service is exceptional. Will definitely stay here again!"</p>
                        </div>
                        <div className="bg-gray-50 p-6 rounded-lg">
                            <div className="flex items-center mb-4">
                                <div className="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                    <span className="text-lg">👤</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold">Jane Smith</h4>
                                    <p className="text-gray-600 text-sm">Family Vacation</p>
                                </div>
                            </div>
                            <p className="text-gray-700">"Perfect for families! The amenities were great and the staff was very accommodating."</p>
                        </div>
                        <div className="bg-gray-50 p-6 rounded-lg">
                            <div className="flex items-center mb-4">
                                <div className="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                    <span className="text-lg">👤</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold">Mike Johnson</h4>
                                    <p className="text-gray-600 text-sm">Honeymoon</p>
                                </div>
                            </div>
                            <p className="text-gray-700">"An unforgettable experience! The luxury suite was perfect for our special occasion."</p>
                        </div>
                    </div>
                </div>
            </section>
        </FrontendLayout>
    );
};

export default Home;