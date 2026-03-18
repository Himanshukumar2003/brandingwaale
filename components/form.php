    <div class="modal-overlay" id="contactModal" onclick="if(event.target===this)closeModal()">
        <div class="cmodal">
            <button class="modal-close" onclick="closeModal()">&#x2715;</button>
            <p class="modal-eyebrow">Let's Connect</p>
            <h2 class="modal-title">Start Your <span>Journey</span></h2>
            <p class="modal-sub">Tell us about your brand and we'll craft the perfect strategy for your market.</p>
            <div class="modal-divider"></div>

            <div id="mFormContent">
                <div class="mform-row">
                    <div class="mform-group">
                        <label>Full Name *</label>
                        <input type="text" class="mform-control" placeholder="John Doe" id="mName">
                    </div>
                    <div class="mform-group">
                        <label>Email Address *</label>
                        <input type="email" class="mform-control" placeholder="john@company.com" id="mEmail">
                    </div>
                </div>
                <div class="mform-row">
                    <div class="mform-group">
                        <label>Company</label>
                        <input type="text" class="mform-control" placeholder="Your Company Name" id="mCompany">
                    </div>
                    <div class="mform-group">
                        <label>Phone Number *</label>
                        <div class="phone-row">
                            <select class="phone-code" id="mPhoneCode">
                                <option value="+91">🇮🇳 +91</option>
                                <option value="+971">🇦🇪 +971</option>
                                <option value="+1">🇺🇸 +1</option>
                                <option value="+44">🇬🇧 +44</option>
                                <option value="+61">🇦🇺 +61</option>
                                <option value="+49">🇩🇪 +49</option>
                                <option value="+33">🇫🇷 +33</option>
                                <option value="+86">🇨🇳 +86</option>
                                <option value="+55">🇧🇷 +55</option>
                                <option value="+52">🇲🇽 +52</option>
                                <option value="+34">🇪🇸 +34</option>
                                <option value="+39">🇮🇹 +39</option>
                                <option value="+31">🇳🇱 +31</option>
                                <option value="+82">🇰🇷 +82</option>
                                <option value="+65">🇸🇬 +65</option>
                                <option value="+92">🇵🇰 +92</option>
                                <option value="+880">🇧🇩 +880</option>
                                <option value="+977">🇳🇵 +977</option>
                                <option value="+213">🇩🇿 +213</option>
                                <option value="+54">🇦🇷 +54</option>
                                <option value="+43">🇦🇹 +43</option>
                                <option value="+32">🇧🇪 +32</option>
                                <option value="+359">🇧🇬 +359</option>
                                <option value="+56">🇨🇱 +56</option>
                                <option value="+57">🇨🇴 +57</option>
                                <option value="+20">🇪🇬 +20</option>
                                <option value="+358">🇫🇮 +358</option>
                                <option value="+30">🇬🇷 +30</option>
                                <option value="+36">🇭🇺 +36</option>
                                <option value="+98">🇮🇷 +98</option>
                                <option value="+964">🇮🇶 +964</option>
                                <option value="+353">🇮🇪 +353</option>
                                <option value="+972">🇮🇱 +972</option>
                                <option value="+962">🇯🇴 +962</option>
                                <option value="+254">🇰🇪 +254</option>
                                <option value="+965">🇰🇼 +965</option>
                                <option value="+961">🇱🇧 +961</option>
                                <option value="+60">🇲🇾 +60</option>
                                <option value="+212">🇲🇦 +212</option>
                                <option value="+234">🇳🇬 +234</option>
                                <option value="+47">🇳🇴 +47</option>
                                <option value="+968">🇴🇲 +968</option>
                                <option value="+507">🇵🇦 +507</option>
                                <option value="+63">🇵🇭 +63</option>
                                <option value="+48">🇵🇱 +48</option>
                                <option value="+351">🇵🇹 +351</option>
                                <option value="+974">🇶🇦 +974</option>
                                <option value="+40">🇷🇴 +40</option>
                                <option value="+7">🇷🇺 +7</option>
                                <option value="+966">🇸🇦 +966</option>
                                <option value="+27">🇿🇦 +27</option>
                                <option value="+46">🇸🇪 +46</option>
                                <option value="+41">🇨🇭 +41</option>
                                <option value="+886">🇹🇼 +886</option>
                                <option value="+66">🇹🇭 +66</option>
                                <option value="+216">🇹🇳 +216</option>
                                <option value="+90">🇹🇷 +90</option>
                                <option value="+380">🇺🇦 +380</option>
                                <option value="+971">🇦🇪 +971</option>
                                <option value="+84">🇻🇳 +84</option>
                                <option value="+967">🇾🇪 +967</option>
                                <option value="+263">🇿🇼 +263</option>
                            </select>
                            <input type="tel" class="mform-control" placeholder="98765 43210" id="mPhone" style="flex:1;">
                        </div>
                    </div>
                </div>

                <div class="mform-group">
                    <label>Services Required *</label>
                    <div class="services-list">
                        <?php
                        $services = ['Digital Marketing', 'Web Development', 'Mobile Development', 'UI/UX Design', 'SEO', 'Performance Marketing', 'Brand Communication', 'Content Creation', 'Social Media Marketing', 'Business Consulting', 'Others'];
                        foreach ($services as $svc): ?>
                            <div class="svc-item" onclick="this.classList.toggle('selected')">
                                <div class="chk-box"><span class="chk-mark">&#10003;</span></div>
                                <span class="svc-name"><?= htmlspecialchars($svc) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mform-group" style="margin-top:4px;">
                    <label>Share Your Message</label>
                    <textarea class="mform-control" placeholder="Tell us about your project, goals, or any questions..." id="mMessage"></textarea>
                </div>

                <p class="modal-err" id="mErr">Please fill in all required fields and select at least one service.</p>
                <button class="modal-submit" onclick="submitModalForm()">Send Message &rarr;</button>
            </div>

            <div class="modal-success" id="mSuccess">
                <div class="success-icon-circle">&#10003;</div>
                <h3>Message Sent!</h3>
                <p>Thank you for reaching out. Our team will get back to you within 24 hours.</p>
            </div>
        </div>
    </div>