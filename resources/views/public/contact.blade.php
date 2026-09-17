@extends('layouts.app')

@section('content')

{{-- ========================= --}}
{{-- CONTACT HEADER --}}
{{-- ========================= --}}
<section class="section">
    <h1 class="page-title">Contact Us</h1>
    <p class="subtitle">
        Have questions or want to support turtle conservation?  
        Reach out to us — we’d love to hear from you!
    </p>
</section>

{{-- ========================= --}}
{{-- CONTACT INFO --}}
{{-- ========================= --}}
<section class="section" style="background:#f9fdfd;">
    <div style="max-width:900px;margin:0 auto;text-align:left;display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:40px;">
        
        <div>
            <h2>Get In Touch</h2>
            <p><strong>📍 Address:</strong><br>
                Turtle Conservation Society of Malaysia<br>
                Kg. Pasir Gajah, 24000 Kemaman, Terengganu, Malaysia
            </p>
            <p><strong>📞 Phone:</strong><br> +60 19-914 2911</p>
            <p><strong>📧 Email:</strong><br> info@turtleconservationsociety.org.my</p>
            <p><strong>🕓 Office Hours:</strong><br> Monday - Friday: 9:00 AM - 5:00 PM</p>
        </div>

        <div>
            <h2>Send Us a Message</h2>
            <form action="{{ route('contact.send') }}" method="POST" class="contact-form" style="display:flex;flex-direction:column;gap:12px;">
                @csrf
                <input type="text" name="name" placeholder="Your Name" required style="padding:10px;border:1px solid #ccc;border-radius:8px;">
                <input type="email" name="email" placeholder="Your Email" required style="padding:10px;border:1px solid #ccc;border-radius:8px;">
                <textarea name="message" rows="4" placeholder="Your Message" required style="padding:10px;border:1px solid #ccc;border-radius:8px;"></textarea>
                <button type="submit" class="btn btn-primary" style="width:150px;">Send Message</button>
            </form>
        </div>
    </div>
</section>

{{-- ========================= --}}
{{-- MAP SECTION --}}
{{-- ========================= --}}
<section class="section">
    <h2>Find Us on the Map</h2>
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127535.32642381516!2d103.37686731640624!3d4.239326500000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31b6c8b41cd52707%3A0x2f8e54a7a13db97!2sTurtle%20Conservation%20Society%20of%20Malaysia!5e0!3m2!1sen!2smy!4v1706906031921!5m2!1sen!2smy" 
        width="100%" 
        height="400" 
        style="border:0;border-radius:10px;margin-top:20px;" 
        allowfullscreen="" 
        loading="lazy">
    </iframe>
</section>

@endsection
