import React from 'react'
import HeroSection from '../components/HeroSection'
import WhyChooseUs from '../components/WhyChooseUs'
import WeHelpSection from '../components/WeHelpSection'
import PopularProduct from '../components/PopularProduct'
import TestimonialSlider from '../components/TestimonialSlider'
import BlogSection from '../components/BlogSection'
import ProductSection from '../components/ProductSection'

function Home() {
  return (
    <div>
       <HeroSection 
        title="Modern Interior"
        subtitle="Design Studio"
        description="Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique."
      />
      <ProductSection/>
      <WhyChooseUs />
      <WeHelpSection />
      <PopularProduct/>
      <TestimonialSlider />
      <BlogSection />
    </div>
  )
}

export default Home