<x-layout bodyClass="">
    <!-- Navigation -->
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-navbars.navs.guest signup='register' signin='login'></x-navbars.navs.guest>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-particles"></div>
        <div class="hero-content">
            <div class="hero-logo animate-bounce-in">
                <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="logo-image">
                <div class="logo-glow"></div>
            </div>
            <h1 class="hero-title animate-fade-up">
                Transform Waste Into <span class="text-gradient">Wealth</span>
            </h1>
            <p class="hero-subtitle animate-fade-up-delay">
                Join the circular economy revolution. Ecoverse connects waste generators, processors, and manufacturers in a sustainable ecosystem that turns today's waste into tomorrow's resources.
            </p>
            <div class="hero-buttons animate-fade-up-delay-2">
                <a href="{{ route('login') }}" class="btn-primary-modern">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Get Started</span>
                </a>
                <a href="{{ route('register') }}" class="btn-secondary-modern">
                    <i class="bi bi-person-plus"></i>
                    <span>Join Ecoverse</span>
                </a>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="floating-elements">
            <div class="floating-icon animate-float-1">
                <i class="bi bi-recycle"></i>
            </div>
            <div class="floating-icon animate-float-2">
                <i class="bi bi-leaf"></i>
            </div>
            <div class="floating-icon animate-float-3">
                <i class="bi bi-globe"></i>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-header animate-on-scroll">
                <h2 class="section-title">Why Choose Ecoverse?</h2>
                <p class="section-subtitle">Comprehensive waste management solutions for a sustainable future</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card animate-on-scroll" data-delay="0">
                    <div class="feature-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h3>Circular Economy</h3>
                    <p>Transform waste streams into valuable resources through our intelligent matching system that connects waste generators with processors, creating a seamless circular economy ecosystem.</p>
                </div>
                
                <div class="feature-card animate-on-scroll" data-delay="100">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h3>Smart Analytics</h3>
                    <p>Track your environmental impact and optimize waste management with real-time insights, predictive analytics, and comprehensive reporting dashboards for data-driven decisions.</p>
                </div>
                
                <div class="feature-card animate-on-scroll" data-delay="200">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>Connected Network</h3>
                    <p>Join a thriving community of factories, wholesalers, retailers, and eco-conscious consumers working together to create sustainable supply chains and reduce environmental impact.</p>
                </div>
                
                <div class="feature-card animate-on-scroll" data-delay="300">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3>Verified Quality</h3>
                    <p>Ensure compliance and quality with our comprehensive verification system, including material certification, supplier validation, and automated quality control processes.</p>
                </div>
                
                <div class="feature-card animate-on-scroll" data-delay="400">
                    <div class="feature-icon">
                        <i class="bi bi-lightning"></i>
                    </div>
                    <h3>Real-time Processing</h3>
                    <p>Experience instant order processing, inventory management, and transaction handling with our high-performance platform designed for efficient waste management operations.</p>
                </div>
                
                <div class="feature-card animate-on-scroll" data-delay="500">
                    <div class="feature-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h3>Sustainability Goals</h3>
                    <p>Achieve your ESG targets with measurable environmental impact reporting, carbon footprint tracking, and comprehensive sustainability metrics for corporate responsibility.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="about-container">
            <div class="about-content">
                <div class="about-text animate-on-scroll">
                    <h2 class="about-title">About Ecoverse</h2>
                    <p class="about-subtitle">Pioneering the Future of Waste Management</p>
                    <div class="about-description">
                        <p>Ecoverse is a revolutionary waste management platform that transforms how businesses and communities handle waste. Our innovative technology bridges the gap between waste generators and processors, creating valuable opportunities from what was once considered disposable.</p>
                        
                        <p>Founded on the principles of circular economy and sustainability, Ecoverse enables factories, wholesalers, retailers, and consumers to participate in a comprehensive ecosystem where waste becomes a resource. Our platform facilitates seamless transactions, ensures quality verification, and provides real-time analytics to optimize environmental impact.</p>
                        
                        <p>Through advanced machine learning algorithms and intelligent matching systems, we connect stakeholders across the waste management value chain, reducing environmental footprint while creating economic value. Join us in building a sustainable future where nothing goes to waste.</p>
                    </div>
                    
                    <div class="about-highlights">
                        <div class="highlight-item">
                            <i class="bi bi-globe"></i>
                            <div>
                                <h4>Global Impact</h4>
                                <p>Serving communities worldwide with localized solutions</p>
                            </div>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-cpu"></i>
                            <div>
                                <h4>AI-Powered</h4>
                                <p>Advanced algorithms for optimal waste-to-resource matching</p>
                            </div>
                        </div>
                        <div class="highlight-item">
                            <i class="bi bi-heart"></i>
                            <div>
                                <h4>Community Focused</h4>
                                <p>Building sustainable communities through collaborative action</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="about-visual animate-on-scroll" data-delay="200">
                    <div class="visual-card">
                        <div class="visual-content">
                            <h3>Our Mission</h3>
                            <p>To create a world where waste is eliminated through innovative technology, community collaboration, and sustainable practices that benefit both the environment and economy.</p>
                        </div>
                    </div>
                    <div class="visual-card">
                        <div class="visual-content">
                            <h3>Our Vision</h3>
                            <p>To be the leading global platform for waste transformation, enabling a circular economy where every material finds its highest and best use.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="team-container">
            <div class="section-header animate-on-scroll">
                <h2 class="section-title">Meet Our Team</h2>
                <p class="section-subtitle">The brilliant minds behind Ecoverse's innovative solutions</p>
            </div>
            
            <div class="team-grid">
                <div class="team-card animate-on-scroll" data-delay="0">
                    <div class="team-photo">
                        <img src="/assets/img/team/alvin.jpg" alt="Alvin" class="team-image">
                        <div class="team-overlay">
                            <div class="team-social">
                                <i class="bi bi-linkedin"></i>
                                <i class="bi bi-github"></i>
                            </div>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3>Alvin</h3>
                        <p class="team-role">Lead Developer & Architect</p>
                        <p class="team-description">A visionary developer with exceptional leadership skills and deep technical expertise. Alvin's innovative approach to problem-solving and commitment to sustainable technology drives Ecoverse's core architecture and strategic direction.</p>
                    </div>
                </div>
                
                <div class="team-card animate-on-scroll" data-delay="100">
                    <div class="team-photo">
                        <img src="/assets/img/team/benedict.jpg" alt="Benedict" class="team-image">
                        <div class="team-overlay">
                            <div class="team-social">
                                <i class="bi bi-linkedin"></i>
                                <i class="bi bi-github"></i>
                            </div>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3>Benedict</h3>
                        <p class="team-role">Full-Stack Developer</p>
                        <p class="team-description">A brilliant full-stack engineer with remarkable versatility and attention to detail. Benedict's expertise in both frontend and backend technologies ensures seamless user experiences and robust system performance across all Ecoverse platforms.</p>
                    </div>
                </div>
                
                <div class="team-card animate-on-scroll" data-delay="200">
                    <div class="team-photo">
                        <img src="/assets/img/team/shamma.jpg" alt="Shamma" class="team-image">
                        <div class="team-overlay">
                            <div class="team-social">
                                <i class="bi bi-linkedin"></i>
                                <i class="bi bi-github"></i>
                            </div>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3>Shamma</h3>
                        <p class="team-role">UI/UX Specialist & Developer</p>
                        <p class="team-description">An exceptional designer-developer with an eye for creating intuitive and beautiful user interfaces. Shamma's creative vision and technical prowess craft engaging experiences that make sustainable practices accessible and enjoyable for all users.</p>
                    </div>
                </div>
                
                <div class="team-card animate-on-scroll" data-delay="300">
                    <div class="team-photo">
                        <img src="/assets/img/team/brina.jpg" alt="Brina" class="team-image">
                        <div class="team-overlay">
                            <div class="team-social">
                                <i class="bi bi-linkedin"></i>
                                <i class="bi bi-github"></i>
                            </div>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3>Brina</h3>
                        <p class="team-role">Backend Developer & Data Engineer</p>
                        <p class="team-description">A dedicated backend specialist with extraordinary analytical skills and precision in data management. Brina's expertise in database optimization and API development ensures Ecoverse's data flows efficiently and securely across all systems.</p>
                    </div>
                </div>
                
                <div class="team-card animate-on-scroll" data-delay="400">
                    <div class="team-photo">
                        <img src="/assets/img/team/kevin.jpg" alt="Kevin" class="team-image">
                        <div class="team-overlay">
                            <div class="team-social">
                                <i class="bi bi-linkedin"></i>
                                <i class="bi bi-github"></i>
                            </div>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3>Kevin</h3>
                        <p class="team-role">DevOps Engineer & Systems Architect</p>
                        <p class="team-description">A meticulous DevOps engineer with outstanding infrastructure expertise and deployment strategies. Kevin's commitment to system reliability and performance optimization ensures Ecoverse operates smoothly at scale with maximum uptime and security.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-item animate-counter" data-target="95">
                    <div class="stat-number">0%</div>
                    <div class="stat-label">Waste Diverted</div>
                </div>
                <div class="stat-item animate-counter" data-target="1000">
                    <div class="stat-number">0+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat-item animate-counter" data-target="50">
                    <div class="stat-number">0+</div>
                    <div class="stat-label">Partner Companies</div>
                </div>
                <div class="stat-item animate-counter" data-target="500">
                    <div class="stat-number">0</div>
                    <div class="stat-label">Tons Recycled</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Ready to Make a Difference?</h2>
                <p class="cta-subtitle">Join Ecoverse today and be part of the sustainable revolution</p>
                <a href="{{ route('register') }}" class="cta-button">
                    <span>Start Your Journey</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <x-footers.guest></x-footers.guest>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #10b981 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="%2310b981" opacity="0.3"/><circle cx="80" cy="40" r="1.5" fill="%236366f1" opacity="0.4"/><circle cx="40" cy="80" r="1" fill="%23f59e0b" opacity="0.3"/><circle cx="70" cy="70" r="1.2" fill="%2310b981" opacity="0.5"/></svg>');
            animation: float-particles 20s infinite linear;
        }
        
        @keyframes float-particles {
            0% { transform: translateY(100vh) rotate(0deg); }
            100% { transform: translateY(-100vh) rotate(360deg); }
        }
        
        .hero-content {
            text-align: center;
            z-index: 2;
            max-width: 900px;
            padding: 2rem;
        }
        
        .hero-logo {
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .logo-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 3px solid rgba(16, 185, 129, 0.5);
            padding: 1rem;
            filter: drop-shadow(0 8px 32px rgba(16, 185, 129, 0.3));
        }
        
        .logo-glow {
            position: absolute;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulse-glow {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 2rem;
            line-height: 1.1;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #10b981, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 3rem;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-primary-modern, .btn-secondary-modern {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary-modern {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
        }
        
        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(16, 185, 129, 0.4);
            color: white;
        }
        
        .btn-secondary-modern {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary-modern:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
        }
        
        /* Floating Elements */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .floating-icon {
            position: absolute;
            font-size: 2rem;
            color: rgba(16, 185, 129, 0.6);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        .animate-float-1 {
            top: 20%;
            left: 10%;
            animation: float-1 6s ease-in-out infinite;
        }
        
        .animate-float-2 {
            top: 60%;
            right: 15%;
            animation: float-2 8s ease-in-out infinite;
        }
        
        .animate-float-3 {
            bottom: 20%;
            left: 20%;
            animation: float-3 7s ease-in-out infinite;
        }
        
        @keyframes float-1 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        @keyframes float-2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(-180deg); }
        }
        
        @keyframes float-3 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(180deg); }
        }
        
        /* Features Section */
        .features-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        
        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 5rem;
        }
        
        .section-title {
            font-size: 3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }
        
        .feature-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(16, 185, 129, 0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .feature-card p {
            color: #64748b;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats-section {
            padding: 6rem 0;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
        }
        
        .stats-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #10b981, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* About Section */
        .about-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }
        
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }
        
        .about-title {
            font-size: 3rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .about-subtitle {
            font-size: 1.3rem;
            color: #10b981;
            font-weight: 600;
            margin-bottom: 2rem;
        }
        
        .about-description {
            margin-bottom: 3rem;
        }
        
        .about-description p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #64748b;
            margin-bottom: 1.5rem;
        }
        
        .about-highlights {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .highlight-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.1);
        }
        
        .highlight-item i {
            font-size: 2rem;
            color: #10b981;
            min-width: 40px;
        }
        
        .highlight-item h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .highlight-item p {
            color: #64748b;
            margin: 0;
        }
        
        .about-visual {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .visual-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .visual-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #10b981, #6366f1);
        }
        
        .visual-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .visual-content p {
            color: #64748b;
            line-height: 1.6;
        }
        
        /* Team Section */
        .team-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
        }
        
        .team-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }
        
        .team-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.3);
        }
        
        .team-photo {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid rgba(16, 185, 129, 0.3);
        }
        
        .team-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .team-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(16, 185, 129, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .team-photo:hover .team-overlay {
            opacity: 1;
        }
        
        .team-photo:hover .team-image {
            transform: scale(1.1);
        }
        
        .team-social {
            display: flex;
            gap: 1rem;
        }
        
        .team-social i {
            font-size: 1.5rem;
            color: white;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .team-social i:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }
        
        .team-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #10b981, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .team-role {
            font-size: 1.1rem;
            color: #10b981;
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .team-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        /* Placeholder for missing team images */
        .team-image[src*="team/"]:not([src$=".jpg"]):not([src$=".png"]):not([src$=".jpeg"]) {
            background: linear-gradient(135deg, #10b981, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
            color: white;
        }
        
        .team-image[src*="team/"]:not([src$=".jpg"]):not([src$=".png"]):not([src$=".jpeg"])::before {
            content: attr(alt);
        }
        
        /* CTA Section */
        .cta-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .cta-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }
        
        .cta-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .cta-subtitle {
            font-size: 1.3rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }
        
        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            padding: 1.2rem 3rem;
            background: white;
            color: #10b981;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
            color: #059669;
        }
        
        /* Animations */
        .animate-bounce-in {
            animation: bounceIn 1s ease-out;
        }
        
        .animate-fade-up {
            animation: fadeUp 1s ease-out 0.3s both;
        }
        
        .animate-fade-up-delay {
            animation: fadeUp 1s ease-out 0.6s both;
        }
        
        .animate-fade-up-delay-2 {
            animation: fadeUp 1s ease-out 0.9s both;
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        @keyframes fadeUp {
            0% { transform: translateY(30px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.1rem; }
            .section-title { font-size: 2rem; }
            .features-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-buttons { flex-direction: column; align-items: center; }
            
            /* About Section Mobile */
            .about-content { 
                grid-template-columns: 1fr; 
                gap: 3rem; 
            }
            .about-title { font-size: 2.5rem; }
            .highlight-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            /* Team Section Mobile */
            .team-grid { 
                grid-template-columns: 1fr; 
                gap: 2rem; 
            }
            .team-photo {
                width: 150px;
                height: 150px;
            }
            
            /* CTA Section Mobile */
            .cta-title { font-size: 2rem; }
            .cta-subtitle { font-size: 1.1rem; }
        }
        
        @media (max-width: 480px) {
            .hero-title { font-size: 2rem; }
            .section-title { font-size: 1.8rem; }
            .about-title { font-size: 2rem; }
            .cta-title { font-size: 1.8rem; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
    
    <script>
        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.dataset.delay || 0;
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, delay);
                }
            });
        }, observerOptions);
        
        document.addEventListener('DOMContentLoaded', () => {
            // Observe scroll animations
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
            
            // Counter animations
            const counters = document.querySelectorAll('.animate-counter');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.dataset.target);
                        const numberEl = counter.querySelector('.stat-number');
                        let current = 0;
                        const increment = target / 100;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            if (target >= 1000) {
                                numberEl.textContent = Math.floor(current) + '+';
                            } else if (target === 95) {
                                numberEl.textContent = Math.floor(current) + '%';
                            } else {
                                numberEl.textContent = Math.floor(current);
                            }
                        }, 20);
                        counterObserver.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });
            
            counters.forEach(counter => {
                counterObserver.observe(counter);
            });
        });
    </script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</x-layout>
