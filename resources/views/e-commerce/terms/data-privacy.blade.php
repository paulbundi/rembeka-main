@extends('layouts.e-commerce')
@push('css')
<style type="text/css">
      @page {}

      table {
        border-collapse: collapse;
        border-spacing: 0;
        empty-cells: show
      }

      td,
      th {
        vertical-align: top;
        font-size: 12pt;
      }

      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        clear: both;
      }

      ol,
      ul {
        margin: 0;
        padding: 0;
      }

      li {
        list-style: none;
        margin: 0;
        padding: 0;
      }

      /* "li span.odfLiEnd" - IE 7 issue*/
      li span. {
        clear: both;
        line-height: 0;
        width: 0;
        height: 0;
        margin: 0;
        padding: 0;
      }

      span.footnodeNumber {
        padding-right: 1em;
      }

      span.annotation_style_by_filter {
        font-family: Arial;
        background-color: #fff000;
        margin: 0;
        border: 0;
        padding: 0;
      }

      span.heading_numbering {
        margin-right: 0.8rem;
      }

      * {
        margin: 0;
      }

      .P1 {
       
        line-height: 108%;
        margin-bottom: 0.111in;
        margin-top: 0in;
        text-align: justify ! important;
        writing-mode: lr-tb;
      }

      .P2_borderStart {
       
        line-height: 108%;
        margin-top: 0in;
        text-align: justify ! important;
        
        writing-mode: lr-tb;
        color: #000000;
        background-color: transparent;
        padding-bottom: 0.111in;
        border-bottom-style: none;
      }

      .P2 {
       
        line-height: 108%;
        text-align: justify ! important;
        
        writing-mode: lr-tb;
        color: #000000;
        background-color: transparent;
        padding-bottom: 0.111in;
        padding-top: 0in;
        border-top-style: none;
        border-bottom-style: none;
      }

      .P2_borderEnd {
       
        line-height: 108%;
        margin-bottom: 0.111in;
        text-align: justify ! important;
        
        writing-mode: lr-tb;
        color: #000000;
        background-color: transparent;
        padding-top: 0in;
        border-top-style: none;
      }

      .P3 {
       
        line-height: 108%;
        margin-bottom: 0.111in;
        margin-top: 0in;
        text-align: justify ! important;
        writing-mode: lr-tb;
      }

      .T1 {
        color: #000000;
        
        text-decoration: underline;
        font-weight: bold;
        background-color: transparent;
      }

      .T2 {
        color: #000000;
        
        background-color: transparent;
      }

      .T3 {
        color: #000000;
        background-color: transparent;
      }

      .T4 {
        color: #000000;
        font-weight: bold;
        background-color: transparent;
      }

    </style>
@endpush
@section('content')
<main style="padding-top: 5rem;">
    <section class="ps-lg-4 pe-lg-3 pt-4">
        <div class="px-3 pt-2">
    <p class="P3">
      <span class="T1">PRIVACY POLICY</span>
    </p>
    <p class="P1">
      <span class="T2">At Rembeka, we are committed to protecting your privacy and we take great care with your Personal Data.</span>
    </p>
    <p class="P1">
      <span class="T2">This privacy policy explains what Personal Data we collect from you, what we use that Personal Data for, with whom the Personal Data is shared and how it is protected and stored. It also sets out your rights and who you can contact for Personal Data or queries.</span>
    </p>
    <p class="P1">
      <span class="T2">If you have any questions, feel free to contact us at</span>
      <span class="T3">style@rembeka.com</span>
      <span class="T2">.</span>
    </p>
    <p class="P1">
      <span class="T2">This privacy policy should be read together with our Terms and Conditions, which together apply to your use of the </span>
      <span class="T2">Rem</span>
      <a id="_GoBack" />
      <span class="T2">beka</span>
      <span class="T2"> website and platform.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">By accessing or using the </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> Website and associated services, you agree to the practices and policies outlined in this privacy policy and you hereby consent to the collection, use, and sharing of your Personal Data as described in this privacy policy</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Personal Data” means Personal Data about a natural person who is identified or can be identified from that Personal Data (either by itself or when combined with other Personal Data).</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">1. </span>
      <span class="T1">What Personal Data do we collect?</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Information from Third-Party Sources</span>
    </p>
    <p class="P1">
      <span class="T2">Some third parties, such as our business partners and service providers, provide us with Personal Data about you. If you interact with a third-party service when using our services, such as if you use a third-party service to log-in to our services (e.g., Facebook or Google), or if you share content from our services through a third party social media service, the third-party service will send us certain Personal Data about you if the third-party service and your account settings allow such sharing. The Personal Data we receive will depend on the policies and your account settings with the third-party service. You understand the Personal Data transmitted to us is covered by this Privacy Policy; for example, the basic Personal Data we receive from Google if you choose to sign up with your Google account.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Information </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> Automatically Collects When You Use The services</span>
    </p>
    <p class="P1">
      <span class="T2">Some Personal Data, which may include Personal Data, is automatically collected when you use our services, such as traffic data. We also may automatically collect </span>
      <span class="T2">certain data when you use the services, such as (1) IP address; (2) domain server; (3) type of device(s) used to access the services; (4) web browser(s) used to access the services; (5) referring webpage or other source through which you accessed the services; (6) geolocation Personal Data; and(7) other statistics and Personal Data associated with the interaction between your browser or device and the services.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">2. </span>
      <span class="T1">How </span>
      <span class="T1">Rembeka</span>
      <span class="T1"> Collects Information</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Rembeka</span>
      <span class="T2"> collects Personal Data (including Personal Data and traffic data) when you use and interact with the services, and in some cases from third party sources. Such means of collection include:</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">When you use the services’ interactive tools and services, such as searching for </span>
      <span class="T2">beauty service providers</span>
      <span class="T2"> and searching for available appointments with </span>
      <span class="T2">the beauticians</span>
      <span class="T2"> prior to </span>
      <span class="T2">the </span>
      <span class="T2">appointment</span>
      <span class="T2">s</span>
      <span class="T2">;</span>
    </p>
    <p class="P1">
      <span class="T2">When you voluntarily provide Personal Data in free-form text boxes through the services or through responses to surveys;</span>
    </p>
    <p class="P1">
      <span class="T2">If you download and install certain applications and software we make available, we may receive and collect Personal Data transmitted from your computing device for the purpose of providing you the relevant services;</span>
    </p>
    <p class="P1">
      <span class="T2">If you use a location-enabled browser or download our mobile application, we may receive Personal Data about your location and mobile device, as applicable;</span>
    </p>
    <p class="P1">
      <span class="T2">Through cookies, analytics services and other tracking technology, as</span>
    </p>
    <p class="P1">
      <span class="T2">When you use the “Contact Us” function on the Site, send us an email or otherwise contact us.</span>
    </p>
    <p class="P1">
      <span class="T2">3. For what purpose do we collect the Personal Data?</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">We collect this data to improve services for the user.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">4. </span>
      <span class="T1">Tracking Tools</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">We may use tools outlined below in order to provide our services to, advertise to, and to better understand users.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Cookies: “Cookies” are small computer files transferred to your computing device that contain Personal Data such as user ID, user preferences, lists of pages visited and activities conducted while using the services. We use cookies to improve or tailor the services, customize advertisements by tracking navigation habits, measuring performance, and storing authentication status so re-entering credentials may not be required, customize user experiences with the services, and for analytics and fraud prevention.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Web Analytics services: We may use third-party analytics services in connection with our services, including, for example, to collect your country where you are logging on, IP address, time spent on the Website or mobile applications, pages visited and other user Personal Data.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">5. </span>
      <span class="T1">Who do we share this Personal Data with?</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">We may disclose and transfer your Personal Data in connection with such partners’ use of the services</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">In certain circumstances, and in order to perform the services, we may share certain Personal Data that we collect from you to select third parties, agents, contractors and service providers or partners with restrictions that they may not use your Personal Data for any other purposes and on the basis of a Non-Disclosure agreement and subject to compliance with Data Protection Laws, as described in this section:</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Beauty services </span>
      <span class="T2">Providers: We may share your Personal Data with </span>
      <span class="T2">the beauticians</span>
      <span class="T2"> with whom you choose to schedule through the services.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">We will never sell email addresses to third parties. We may share your Personal Data with our partners to customize or display our advertising.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">We may share your Personal Data and/or traffic data with our partners who perform operational services (such as hosting, billing, fulfilment, data storage, security, insurance verification, web service analytics, or ad serving) and/or who make certain services, features or functionality available to our users.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Public Information and Submissions: You agree that any Personal Data that you may reveal in a review posting, online discussion or forum is intended for the public and is not in any way private. Carefully consider whether to disclose any Personal Data in any public posting or forum. Your submissions may be seen and/or collected by third parties and may be used by others in ways we are unable to control or predict.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Protection of </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> and Others: We also may need to disclose your Personal Data or any other Personal Data we collect about you if we determine in good faith that such disclosure is needed to: (1) comply with or fulfil our obligations under applicable law, regulation, court order or other legal process; (2) protect the rights, property or safety of you, </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> or another</span>
      <span class="T2"></span>
      <span class="T2">party; (3) enforce the Agreement or other agreements with you; or (4) respond to claims that any posting or other content violates third-party rights.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">6</span>
      <span class="T2">. </span>
      <span class="T1">How secure is your Personal Data?</span>
    </p>
    <p class="P1">
      <span class="T2">The security of your Personal Data is important to us. We endeavour to follow generally accepted industry standards to protect the Personal Data submitted to us, both during transmission and in storage as follows;</span>
    </p>
    <p class="P1">
      <span class="T2">A firewall to prevent unauthorized external access to our system.</span>
    </p>
    <p class="P1">
      <span class="T2">Your account is protected by a password for your privacy and security. If you access your account via a third-party site or service, you may have additional or different sign-on protections via that third-party site or service. You must prevent unauthorized access to your account and Personal Data by selecting and protecting your password and/or other sign-on mechanism appropriately and limiting access to your computer or device and browser by signing off after you have finished accessing your account.</span>
    </p>
    <p class="P1">
      <span class="T2">SSL certificates for customer-facing websites and external connections, except connections that go through a secured VPN.</span>
    </p>
    <p class="P1">
      <span class="T2">Our systems have capability to detect any data security breaches and timely appropriate action taken to remedy.</span>
    </p>
    <p class="P1">
      <span class="T2">All our employees are trained to ensure high standards in relation to data protection.</span>
    </p>
    <p class="P1">
      <span class="T2">We use best efforts to keep confidential any Personal Data collected which may be of confidential nature, with the exception of such Personal Data which:</span>
    </p>
    <p class="P1">
      <span class="T2">was already known to us prior to receiving such Personal Data from the end user.</span>
    </p>
    <p class="P1">
      <span class="T2">was received from a third party who is not subject to similar confidentiality restrictions.</span>
    </p>
    <p class="P1">
      <span class="T2">is independently developed by us; and/or</span>
    </p>
    <p class="P1">
      <span class="T2">is required to be disclosed by applicable Law.</span>
    </p>
    <p class="P1">
      <span class="T2">Notwithstanding clause above, we reserve the right to disclose any Personal Data collected to any person if, in our reasonable opinion, it is:</span>
    </p>
    <p class="P1">
      <span class="T2">required by applicable Law.</span>
    </p>
    <p class="P1">
      <span class="T2">necessary to comply with a court order or other legal process.</span>
    </p>
    <p class="P1">
      <span class="T2">We shall take all reasonable precautions to preserve the integrity and prevent any corruption or loss, damage or destruction of Personal Data in our possession</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Our security practices and procedures are certified and are audited on a regular basis.</span>
    </p>
    <p class="P1">
      <span class="T2">Although we make best possible efforts to transmit and store all the Personal Data in a secure operating environment that is not open to the public, there is no such thing as complete security, and we do not guarantee that there will be no unintended disclosures of any Information Collected. If We become aware that any Personal Data has been disclosed in a manner that is not in accordance with this Policy, We will use best efforts to notify you of the nature and extent of such disclosure (to the extent of our knowledge) as soon as reasonably possible and as permitted by Law.</span>
    </p>
    <p class="P1">
      <span class="T2">We store and process your Personal Data on our servers in Amazon Cloud Sevices. We maintain industry standard backup and archival systems.</span>
    </p>
    <p class="P1">
      <span class="T2">Although we make good faith efforts to store Personal Data in a secure operating environment that is not open to the public, we do not and cannot guarantee the security of your Personal Data. If at any time during or after our relationship we believe that the security of your Personal Data may have been compromised, we may seek to notify you of that development. If a notification is appropriate, we will endeavour to notify you as promptly as possible under the circumstances. If we have your e-mail address, we may notify you by e-mail to the most recent e-mail address you have provided us in your account profile. Please keep your e-mail address in your account up to date which can be updated at any time in your account profile.</span>
    </p>
    <p class="P1">
      <span class="T2">7</span>
      <span class="T2">. </span>
      <span class="T1">What Choices Do You Have When Using The Service</span>
      <span class="T1">s.</span>
    </p>
    <p class="P1">
      <span class="T2">You can always opt not to disclose Personal Data to us, but keep in mind some Personal Data may be needed to register with us or to take advantage of some of our features.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">If you are a registered user of the services, you can modify certain Personal Data or account Personal Data by logging in and accessing your account. The Personal Data you can view, update, and delete may change as the services change.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">If you wish to close your account, please email us at </span>
      <span class="T3">style@rembeka.com</span>
      <span class="T2">. </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> will use reasonable efforts to promptly delete your account and the related Personal Data. Please note, however, that </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> reserves the right to retain Personal Data from closed accounts, including to comply with law, prevent fraud, resolve disputes, enforce the agreement and take other actions permitted by law.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">You must promptly notify us if any of your account data is lost, stolen or used without permission.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">8</span>
      <span class="T2">.</span>
      <span class="T1">For how long do we keep your Personal Data? Where do we keep it? How do we keep it?</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">We retain Personal Data about you for as long as you have an open account with us or as otherwise necessary to provide you services. In some cases, we retain Personal Data for longer, if doing so is necessary to comply with our legal obligations, resolve disputes or collect fees owed, prevent fraud, enforce the Agreement, or as otherwise permitted or required by applicable law, rule or regulation. Afterwards, we retain some Personal Data in a depersonalized or aggregated form but not in a way that would identify you personally.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T4">9</span>
      <span class="T2">. </span>
      <span class="T1">Information Provided on Behalf of Minors and Others</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">As noted in the Terms of Use, the services are not intended for use by children and children under the age of 18 should not use our service. </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> does not knowingly collect any Personal Data from minors, nor is the services directed to or attended for use by children. If you are under 18, please do not attempt to register for the services or send any Personal Data about yourself to us.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">If you are a parent or legal guardian of a minor, you may, in compliance with the Agreement, use the services on behalf of such minor. Any Personal Data that you provide us while using the services on behalf of your minor child will be treated as Personal Data as otherwise provided herein.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">If you use the services on behalf of another person, regardless of age, you agree that </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> may contact you for any communication made in connection with providing the services or any legally required communications. You further agree to </span>
      <span class="T2">forward or share any such communication with any person on behalf of whom you are using the services.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">1</span>
      <span class="T2">0</span>
      <span class="T2">. </span>
      <span class="T1">Other Web services</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">The services contain links to or embedded content from third party web services. A link to or embedded content from a non-</span>
      <span class="T2">R</span>
      <span class="T2">embeka</span>
      <span class="T2"> web service does not mean that we endorse that service, the quality or accuracy of Personal Data presented on the non-</span>
      <span class="T2">Rembeka</span>
      <span class="T2"> service or the persons or entities associated with the non-</span>
      <span class="T2">Rembeka</span>
      <span class="T2"> service. If you decide to visit a third-party web service, you are subject to the privacy policy and Terms of Use of the third-party web service as applicable and we are not responsible for the policies and practices of the third-party web service. We encourage you to ask questions before you disclose your Personal Data to others.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">You may have arrived at the services from, or begun your use of the services at, a third-party web service, including a third-party web service that links to </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> or embeds </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> content. The presence of such links or content on third-party web services does not mean that we</span>
      <span class="T2"></span>
      <span class="T2">endorse that web service, the quality or accuracy of Personl Data presented on the non-</span>
      <span class="T2">Rembeka</span>
      <span class="T2"> web service or the persons or entities associated with the non-</span>
      <span class="T2">Rembeka</span>
      <span class="T2"> web service. You may be subject to the privacy policy of the third-party web service as applicable and we are not responsible for the policies and practices of the third-party web services. In addition, the policies and practices of third parties do not apply to your Personal Data, including Personal Data, obtained pursuant to this Privacy Policy.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">1</span>
      <span class="T2">1</span>
      <span class="T2">. </span>
      <span class="T1">Beauty </span>
      <span class="T1">Service Providers and Their Obligations</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">Rembeka</span>
      <span class="T2"> will share basic Personal Data on the user with the </span>
      <span class="T2">beautician</span>
      <span class="T2"> who you elect to visit for an appointment through the Service. This ensures that an appointment can be booked at your preferred time and date. These  </span>
      <span class="T2">Beauty </span>
      <span class="T2">Service Providers may need to collect additional Personal Data from you to build a</span>
      <span class="T2"> client</span>
      <span class="T2"> history while carrying out their duties.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">The </span>
      <span class="T2">Beautician</span>
      <span class="T2"> is required to obtain consent from the </span>
      <span class="T2">Client</span>
      <span class="T2"> in person during their initial consultation, to allow the </span>
      <span class="T2">beautician </span>
      <span class="T2"> to collect and store Personal Data</span>
      <span class="T2"></span>
      <span class="T2">and other Information as needed, on the </span>
      <span class="T2">Client</span>
      <span class="T2">. The </span>
      <span class="T2">Beautician</span>
      <span class="T2"> will not share this Personal Data with us or anyone else without the prior approval of the </span>
      <span class="T2">Client</span>
      <span class="T2">. </span>
    </p>
    <p class="P1">
      <span class="T2">1</span>
      <span class="T2">2</span>
      <span class="T2">. </span>
      <span class="T1">What are your rights as a data subject?</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">We have mechanisms in place to ensure that you can exercise the following legal rights.</span>
    </p>
    <p class="P1">
      <span class="T2">Right to give and withdraw consent at any time</span>
    </p>
    <p class="P1">
      <span class="T2">Right to be informed of the use to which Personal Data is to be put</span>
    </p>
    <p class="P1">
      <span class="T2">Right to access your Personal Data</span>
    </p>
    <p class="P1">
      <span class="T2">Right to object to the processing of all or part of your Personal Data unless there is a compelling legitimate interest or for legal purposes</span>
    </p>
    <p class="P1">
      <span class="T2">Right to request confirmation of what Personal Data is held</span>
    </p>
    <p class="P1">
      <span class="T2">Right to request correction of any errors, omissions, out-dated, Personal Data inaccurate, incomplete or misleading personal data, and request third parties processing the personal data of the request. This will however not apply to Personal Data required for legal purposes</span>
    </p>
    <p class="P1">
      <span class="T2">Right to request cessation of use the Personal Data</span>
    </p>
    <p class="P1">
      <span class="T2">Right to request removal from any contact/mailing list</span>
    </p>
    <p class="P1">
      <span class="T2">Right to restrict use of your Personal Data</span>
    </p>
    <p class="P1">
      <span class="T2">Right to request deletion of Personal Data that is irrelevant, excessive or obtained unlawfully, and request third parties processing the Personal Data of the request. This will however not apply to Personal Data required for legal purposes</span>
    </p>
    <p class="P1">
      <span class="T2">Right to request transfer of Personal Data to another </span>
      <span class="T2">organization</span>
    </p>
    <p class="P1">
      <span class="T2">1</span>
      <span class="T2">3</span>
      <span class="T2">. </span>
      <span class="T1">Review of Policy</span>
    </p>
    <p class="P1">
      <span class="T2">The effective date of this Privacy Policy is set forth at the top of this webpage. We will notify you of any material change by posting notice on this webpage. Your continued use of the services after the effective date constitutes your acceptance of the amended Privacy Policy. We encourage you to periodically review this page for the latest Personal Data on our privacy practices. Any amended Privacy Policy supersedes all previous versions. If you do not agree to future changes to this privacy policy, you must stop using the services after the effective date of such changes</span>
    </p>
    <p class="P2_borderStart" />
    <p class="P2" />
    <p class="P2" />
    <p class="P2_borderEnd" />
    <p class="P1">
      <span class="T1">Consent statement</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">I have read and understood, and agree to </span>
      <span class="T2">Rembeka</span>
      <span class="T2">'s privacy policy.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">I consent to </span>
      <span class="T2">Rembeka</span>
      <span class="T2"> using my personal data for providing me the services.</span>
    </p>
    <p class="P2" />
    <p class="P1">
      <span class="T2">I am aware that I can withdraw my consent at any time by sending an email to</span>
      <span class="T2"></span>
      <span class="T3">style@rembeka.com</span>
    </p>

    </div>
    </section>
</main>

@endsection

@push('scripts')
