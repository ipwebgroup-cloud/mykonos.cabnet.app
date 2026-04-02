(function () {
  var toggle = document.querySelector('.nav-toggle');
  var mobileNav = document.getElementById('mobileNav');
  if (!toggle || !mobileNav) return;

  function closeNav() {
    toggle.setAttribute('aria-expanded', 'false');
    mobileNav.hidden = true;
    document.body.classList.remove('mobile-nav-open');
  }

  function openNav() {
    toggle.setAttribute('aria-expanded', 'true');
    mobileNav.hidden = false;
    document.body.classList.add('mobile-nav-open');
  }

  toggle.addEventListener('click', function (e) {
    e.stopPropagation();
    var open = toggle.getAttribute('aria-expanded') === 'true';
    if (open) closeNav(); else openNav();
  });

  mobileNav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', closeNav);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeNav();
  });

  document.addEventListener('click', function (e) {
    if (mobileNav.hidden) return;
    if (!mobileNav.contains(e.target) && !toggle.contains(e.target)) closeNav();
  });
})();

// v10 small UX helper
document.querySelectorAll('.mobile-nav a').forEach(function(link){
  link.addEventListener('click', function(){
    var nav = document.getElementById('mobileNav');
    var btn = document.querySelector('.nav-toggle');
    if (nav && btn && !nav.hasAttribute('hidden')) {
      nav.setAttribute('hidden', 'hidden');
      btn.setAttribute('aria-expanded','false');
      document.body.classList.remove('mobile-nav-open');
    }
  });
});


// v11 plan-page helpers
(function(){
  var openBtn = document.querySelector('[data-open-optional]');
  var form = document.getElementById('luxury-plan-form');
  var accordion = document.getElementById('optional-trip-profile');
  var steps = document.querySelectorAll('.plan-progress [data-step]');
  var fullName = document.getElementById('full_name');
  var email = document.getElementById('email');
  var details = document.getElementById('details');

  if (openBtn && accordion) {
    openBtn.addEventListener('click', function(){
      accordion.open = true;
      accordion.scrollIntoView({behavior:'smooth', block:'start'});
    });
  }

  if (!steps.length || !fullName || !email || !details || !form) return;

  function updateSteps(){
    var budget = form.querySelector('[name="budget"]');
    var travelStyle = form.querySelector('[name="travel_style"]');
    var privacyLevel = form.querySelector('[name="privacy_level"]');
    var essentialsDone = fullName.value.trim().length > 1 && email.value.trim().length > 3;
    var optionalTouched = !!(accordion && (accordion.open || (budget && budget.value) || (travelStyle && travelStyle.value) || (privacyLevel && privacyLevel.value)));
    var briefDone = details.value.trim().length >= 10;

    steps.forEach(function(step){ step.classList.remove('is-active', 'is-complete'); });
    if (essentialsDone) {
      steps[0].classList.add('is-complete');
    } else {
      steps[0].classList.add('is-active');
    }

    if (essentialsDone && !briefDone) {
      steps[1].classList.add(optionalTouched ? 'is-complete' : 'is-active');
    }

    if (briefDone) {
      steps[2].classList.add('is-active');
    }
  }

  [fullName, email, details].forEach(function(el){ el.addEventListener('input', updateSteps); });
  if (accordion) accordion.addEventListener('toggle', updateSteps);
  ['budget','travel_style','privacy_level'].forEach(function(name){
    var el = form.querySelector('[name="' + name + '"]');
    if (el) el.addEventListener('change', updateSteps);
  });
  updateSteps();
})();


// v12 plan-page helpers
(function(){
  var form = document.getElementById('luxury-plan-form');
  if (!form) return;

  form.querySelectorAll('.focus-chip input').forEach(function(input){
    var label = input.closest('.focus-chip');
    function sync(){ if(label) label.classList.toggle('is-selected', input.checked); }
    input.addEventListener('change', sync);
    sync();
  });

  function focusFirstError(){
    var firstError = Array.prototype.find.call(form.querySelectorAll('.validation-error'), function(el){
      return el.textContent && el.textContent.trim().length > 0;
    });
    if (!firstError) return;
    var field = firstError.closest('.field');
    if (!field) return;
    var control = field.querySelector('input, select, textarea');
    if (control) {
      field.scrollIntoView({behavior:'smooth', block:'center'});
      try { control.focus({preventScroll:true}); } catch (e) { control.focus(); }
    }
  }

  form.addEventListener('submit', function(){
    setTimeout(focusFirstError, 300);
  });
})();


// v16 plan draft autosave
(function(){
  var form = document.getElementById('luxury-plan-form');
  if (!form) return;
  var storageKey = 'mykonos_nocturne_plan_draft_v24';
  var flashSuccess = document.querySelector('.flash-banner.success');
  if (flashSuccess) { try { sessionStorage.removeItem(storageKey); } catch(e) {} return; }

  var controls = form.querySelectorAll('input[name], select[name], textarea[name]');

  function serialize(){
    var data = {};
    controls.forEach(function(el){
      if (!el.name || el.name === 'website') return;
      if ((el.type === 'checkbox' || el.type === 'radio')) {
        if (el.type === 'checkbox') {
          if (!Array.isArray(data[el.name])) data[el.name] = [];
          if (el.checked) data[el.name].push(el.value);
        } else if (el.checked) {
          data[el.name] = el.value;
        }
      } else {
        data[el.name] = el.value;
      }
    });
    return data;
  }

  function saveDraft(){
    try { sessionStorage.setItem(storageKey, JSON.stringify(serialize())); } catch(e) {}
  }

  function restoreDraft(){
    try {
      var raw = sessionStorage.getItem(storageKey);
      if (!raw) return;
      var data = JSON.parse(raw);
      controls.forEach(function(el){
        if (!el.name || !(el.name in data)) return;
        if (el.type === 'checkbox') {
          var vals = data[el.name];
          el.checked = Array.isArray(vals) && vals.indexOf(el.value) !== -1;
        } else if (el.type === 'radio') {
          el.checked = data[el.name] === el.value;
        } else {
          el.value = data[el.name];
        }
      });
      form.querySelectorAll('.focus-chip input').forEach(function(input){
        var label = input.closest('.focus-chip');
        if (label) label.classList.toggle('is-selected', input.checked);
      });
    } catch(e) {}
  }

  restoreDraft();
  controls.forEach(function(el){
    el.addEventListener('input', saveDraft);
    el.addEventListener('change', saveDraft);
  });
})();


// v17 quick inquiry mode + success state
window.NocturnePlan = window.NocturnePlan || {};
window.NocturnePlan.onSuccess = function(){
  var body = document.body;
  if (body) body.classList.add('plan-success-state');
  var panel = document.getElementById('planSuccessPanel');
  var form = document.getElementById('luxury-plan-form');
  if (panel) {
    panel.hidden = false;
    panel.scrollIntoView({behavior:'smooth', block:'start'});
  }
  if (form) {
    form.classList.add('is-submitted');
    try { sessionStorage.removeItem('mykonos_nocturne_plan_draft_v24'); } catch(e) {}
    try { sessionStorage.removeItem('mykonos_nocturne_plan_mode_v24'); } catch(e) {}
  }
};

(function(){
  var form = document.getElementById('luxury-plan-form');
  var toggle = document.querySelector('[data-plan-mode-toggle]');
  if (!form || !toggle) return;
  var key = 'mykonos_nocturne_plan_mode_v24';
  var buttons = toggle.querySelectorAll('[data-plan-mode]');
  function apply(mode){
    form.classList.toggle('is-quick-mode', mode === 'quick');
    buttons.forEach(function(btn){ btn.classList.toggle('is-active', btn.getAttribute('data-plan-mode') === mode); });
    try { sessionStorage.setItem(key, mode); } catch(e) {}
  }
  buttons.forEach(function(btn){
    btn.addEventListener('click', function(){ apply(btn.getAttribute('data-plan-mode')); });
  });
  var initial = 'detailed';
  try {
    var params = new URLSearchParams(window.location.search);
    if (params.get('mode') === 'quick' || params.get('mode') === 'detailed') {
      initial = params.get('mode');
    } else {
      initial = sessionStorage.getItem(key) || (window.matchMedia('(max-width: 820px)').matches ? 'quick' : 'detailed');
    }
  } catch(e) {}
  apply(initial);
  var requestedMode = form.querySelector('#requested_mode');
  if (requestedMode) requestedMode.value = initial;
  buttons.forEach(function(btn){ btn.addEventListener('click', function(){ if (requestedMode) requestedMode.value = btn.getAttribute('data-plan-mode'); }); });
})();


// v22 live summary + reset helpers
(function(){
  var form = document.getElementById('luxury-plan-form');
  if (!form) return;
  var summaryFocus = document.getElementById('summaryFocus');
  var summaryTiming = document.getElementById('summaryTiming');
  var summaryGuests = document.getElementById('summaryGuests');
  var summaryStyle = document.getElementById('summaryStyle');
  var summaryEmpty = document.getElementById('summaryEmptyNote');
  var resetDraftBtn = form.querySelector('[data-reset-draft]');
  var restartBtn = form.querySelector('[data-reset-plan]');
  var draftKey = 'mykonos_nocturne_plan_draft_v24';

  function selectedFocus(){
    var vals = [];
    form.querySelectorAll('.focus-chip input:checked').forEach(function(input){
      var text = input.parentElement ? input.parentElement.textContent.trim() : input.value;
      if (text) vals.push(text);
    });
    return vals;
  }

  function updateSummary(){
    var focus = selectedFocus();
    var arrival = (form.querySelector('[name="arrival_date"]') || {}).value || '';
    var departure = (form.querySelector('[name="departure_date"]') || {}).value || '';
    var arrivalWindow = (form.querySelector('[name="arrival_window"]') || {}).value || '';
    var guests = (form.querySelector('[name="guests"]') || {}).value || '';
    var travelStyle = (form.querySelector('[name="travel_style"]') || {}).value || '';
    var stayMood = (form.querySelector('[name="stay_mood"]') || {}).value || '';
    var details = (form.querySelector('[name="details"]') || {}).value || '';

    if (summaryFocus) summaryFocus.textContent = focus.length ? focus.join(', ') : 'Not chosen yet';

    var timing = [];
    if (arrival) timing.push('Arriving ' + arrival);
    if (departure) timing.push('Leaving ' + departure);
    if (!timing.length && arrivalWindow) timing.push(arrivalWindow + ' arrival');
    if (summaryTiming) summaryTiming.textContent = timing.length ? timing.join(' · ') : 'Dates can be added later';

    if (summaryGuests) summaryGuests.textContent = guests ? guests + ' guest' + (String(guests) === '1' ? '' : 's') : 'Guest count can stay flexible';

    var style = [];
    if (travelStyle) style.push(travelStyle);
    if (stayMood) style.push(stayMood);
    if (!style.length && details.trim().length >= 10) style.push('Stay brief added');
    if (summaryStyle) summaryStyle.textContent = style.length ? style.join(' · ') : 'A short stay brief will complete the picture';

    if (summaryEmpty) {
      summaryEmpty.hidden = !!(focus.length || arrival || departure || arrivalWindow || guests || travelStyle || stayMood || details.trim().length >= 10);
    }
  }

  function resetPlanForm(){
    try { sessionStorage.removeItem(draftKey); } catch(e) {}
    try { sessionStorage.removeItem('mykonos_nocturne_plan_mode_v24'); } catch(e) {}
    form.reset();
    form.classList.remove('is-submitted');
    document.body.classList.remove('plan-success-state');
    var panel = document.getElementById('planSuccessPanel');
    if (panel) panel.hidden = true;
    var accordion = document.getElementById('optional-trip-profile');
    if (accordion) accordion.open = false;
    form.querySelectorAll('.focus-chip').forEach(function(chip){ chip.classList.remove('is-selected'); });
    if (window.matchMedia('(max-width: 820px)').matches) {
      form.classList.add('is-quick-mode');
      form.querySelectorAll('[data-plan-mode]').forEach(function(btn){ btn.classList.toggle('is-active', btn.getAttribute('data-plan-mode') === 'quick'); });
    }
    updateSummary();
    var first = document.getElementById('full_name');
    if (first) { first.scrollIntoView({behavior:'smooth', block:'center'}); try{first.focus({preventScroll:true});}catch(e){first.focus();} }
  }

  form.querySelectorAll('input, select, textarea').forEach(function(el){
    el.addEventListener('input', updateSummary);
    el.addEventListener('change', updateSummary);
  });
  updateSummary();

  if (resetDraftBtn) resetDraftBtn.addEventListener('click', function(){ resetPlanForm(); });
  if (restartBtn) restartBtn.addEventListener('click', function(){ resetPlanForm(); });
})();

// v21 plan prefill from linked detail pages
(function(){
  var form = document.getElementById('luxury-plan-form');
  if (!form || !window.URLSearchParams) return;
  var params = new URLSearchParams(window.location.search);
  var focus = params.get('focus');
  var sourceSlug = params.get('source_slug') || '';
  var travelStyle = params.get('travel_style') || '';
  var occasionType = params.get('occasion_type') || '';
  var groupComposition = params.get('group_composition') || '';
  var map = {
    'hosted-arrivals':'transfers',
    'villa-living':'villas',
    'sea-days':'yachts',
    'concierge-support':'wellness',
    'private-sea-day':'yachts',
    'chora-viewpoint-moments':'celebration',
    'chef-dinner-tasting-night':'dining',
    'hosted-arrival-route':'transfers',
    'couple-escape':'dining',
    'family-villa-stay':'villas',
    'hosted-group':'transfers',
    'celebration-stay':'celebration',
    'executive-hosting':'transfers'
  };
  var pathwayTravelStyle = {
    'couple-escape':'Couple escape',
    'family-villa-stay':'Family villa stay',
    'hosted-group':'Celebration-led travel',
    'celebration-stay':'Celebration-led travel',
    'executive-hosting':'Executive hosting'
  };
  var pathwayGroup = {
    'couple-escape':'Couple',
    'family-villa-stay':'Family',
    'hosted-group':'Hosted group',
    'celebration-stay':'Couple / hosted friends',
    'executive-hosting':'Executive guests'
  };
  var pathwayOccasion = {
    'celebration-stay':'Birthday / Anniversary',
    'couple-escape':'Proposal / Romantic dinner',
    'executive-hosting':'Hosted executive stay'
  };
  var targetKey = focus || sourceSlug;
  var target = map[targetKey] || map[focus] || focus;
  if (target) {
    form.querySelectorAll('.focus-chip input').forEach(function(input){
      if (input.value === target) {
        input.checked = true;
        var label = input.closest('.focus-chip');
        if (label) label.classList.add('is-selected');
      }
    });
  }
  var styleField = form.querySelector('[name="travel_style"]');
  if (styleField && !styleField.value) styleField.value = travelStyle || pathwayTravelStyle[sourceSlug] || '';
  var occasionField = form.querySelector('[name="occasion_type"]');
  if (occasionField && !occasionField.value) occasionField.value = occasionType || pathwayOccasion[sourceSlug] || '';
  var groupField = form.querySelector('[name="group_composition"]');
  if (groupField && !groupField.value) groupField.value = groupComposition || pathwayGroup[sourceSlug] || '';
})();


// v22 contextual inquiry helpers
(function(){
  var form = document.getElementById('luxury-plan-form');
  if (!form) return;
  var ref = form.querySelector('#request_reference');
  var successRef = document.getElementById('successRequestReference');
  var sourceTitle = form.querySelector('#source_title');
  var sourceType = form.querySelector('#source_type');
  var summaryFocus = document.getElementById('summaryFocus');

  function buildReference(){
    var now = new Date();
    var y = String(now.getFullYear()).slice(-2);
    var m = String(now.getMonth()+1).padStart(2,'0');
    var d = String(now.getDate()).padStart(2,'0');
    var rand = Math.random().toString(36).slice(2,8).toUpperCase();
    return 'MNL-' + y + m + d + '-' + rand;
  }

  if (ref && !ref.value) {
    ref.value = buildReference();
  }

  if (successRef && ref) {
    successRef.textContent = ref.value || '—';
  }

  if (sourceTitle && sourceTitle.value && summaryFocus) {
    var current = summaryFocus.textContent || '';
    if (!current || current === 'Not chosen yet') {
      summaryFocus.textContent = sourceTitle.value;
    }
  }

  if (window.NocturnePlan && typeof window.NocturnePlan.onSuccess === 'function') {
    var oldSuccess = window.NocturnePlan.onSuccess;
    window.NocturnePlan.onSuccess = function(){
      if (successRef && ref) successRef.textContent = ref.value || '—';
      oldSuccess();
    };
  }
})();


// v24 request continuity + request care
(function(){
  var continuity = document.getElementById('requestContinuityStrip');
  var resumeLink = document.getElementById('continuityResumeLink');
  var requestLink = document.getElementById('continuityRequestLink');
  var headline = document.getElementById('continuityHeadline');
  var subline = document.getElementById('continuitySubline');
  var dismiss = document.getElementById('continuityDismiss');
  var draftKey = 'mykonos_nocturne_plan_draft_v24';
  var requestKey = 'mykonos_nocturne_last_request_v24';
  var dismissKey = 'mykonos_nocturne_continuity_dismissed_v24';

  if (!continuity || document.body.classList.contains('page-plan')) return;

  function readJSON(key){
    try { return JSON.parse(localStorage.getItem(key) || sessionStorage.getItem(key) || 'null'); } catch(e) { return null; }
  }

  function hasDraft(){
    try { return !!sessionStorage.getItem(draftKey); } catch(e) { return false; }
  }

  function build(){
    var requestData = readJSON(requestKey);
    var dismissed = false;
    try { dismissed = localStorage.getItem(dismissKey) === '1'; } catch(e) {}
    if (dismissed) return;
    if (!hasDraft() && !requestData) return;

    continuity.hidden = false;

    if (requestData && requestLink) {
      requestLink.href = '/request-care?request_reference=' + encodeURIComponent(requestData.request_reference || '') +
        '&source_title=' + encodeURIComponent(requestData.source_title || '') +
        '&source_type=' + encodeURIComponent(requestData.source_type || '') +
        '&requested_mode=' + encodeURIComponent(requestData.requested_mode || '');
    }

    if (hasDraft()) {
      if (headline) headline.textContent = 'You have a saved brief in progress.';
      if (subline) subline.textContent = 'Return to the planning form and keep moving without starting again.';
      if (resumeLink) resumeLink.href = '/plan';
    } else if (requestData) {
      if (headline) headline.textContent = 'Latest request: ' + (requestData.request_reference || 'Saved');
      if (subline) subline.textContent = requestData.source_title ? ('Originally started from ' + requestData.source_title + '.') : 'You can view the latest request care page or start a fresh brief.';
    }
  }

  if (dismiss) {
    dismiss.addEventListener('click', function(){
      continuity.hidden = true;
      try { localStorage.setItem(dismissKey, '1'); } catch(e) {}
    });
  }

  build();
})();

(function(){
  var form = document.getElementById('luxury-plan-form');
  if (!form) return;
  var requestCareLink = document.getElementById('successRequestCareLink');
  var requestKey = 'mykonos_nocturne_last_request_v24';

  function selectedFocus(){
    var vals = [];
    form.querySelectorAll('.focus-chip input:checked').forEach(function(input){
      vals.push(input.value);
    });
    return vals;
  }

  function payload(){
    return {
      request_reference: (form.querySelector('#request_reference') || {}).value || '',
      source_type: (form.querySelector('#source_type') || {}).value || '',
      source_title: (form.querySelector('#source_title') || {}).value || '',
      source_url: (form.querySelector('#source_url') || {}).value || '',
      requested_mode: (form.querySelector('#requested_mode') || {}).value || '',
      focus: selectedFocus(),
      full_name: ((form.querySelector('[name="full_name"]') || {}).value || ''),
      guests: ((form.querySelector('[name="guests"]') || {}).value || ''),
      arrival_date: ((form.querySelector('[name="arrival_date"]') || {}).value || ''),
      departure_date: ((form.querySelector('[name="departure_date"]') || {}).value || '')
    };
  }

  var oldSuccess = window.NocturnePlan && window.NocturnePlan.onSuccess;
  if (typeof oldSuccess === 'function') {
    window.NocturnePlan.onSuccess = function(){
      var data = payload();
      try { localStorage.setItem(requestKey, JSON.stringify(data)); } catch(e) {}
      if (requestCareLink) {
        requestCareLink.href = '/request-care?request_reference=' + encodeURIComponent(data.request_reference || '') +
          '&source_title=' + encodeURIComponent(data.source_title || '') +
          '&source_type=' + encodeURIComponent(data.source_type || '') +
          '&requested_mode=' + encodeURIComponent(data.requested_mode || '');
      }
      oldSuccess();
    };
  }
})();

(function(){
  if (!document.body.classList.contains('page-request-care')) return;
  var requestKey = 'mykonos_nocturne_last_request_v24';
  var ref = document.getElementById('requestCareReference');
  var source = document.getElementById('requestCareSource');
  var mode = document.getElementById('requestCareMode');
  var emailLink = document.getElementById('requestCareEmailLink');
  var resumeLink = document.getElementById('requestCareResumeLink');
  var copyBtn = document.getElementById('requestCareCopyBtn');

  function byQuery(name){
    try { return new URLSearchParams(window.location.search).get(name) || ''; } catch(e) { return ''; }
  }

  var requestData = null;
  try { requestData = JSON.parse(localStorage.getItem(requestKey) || 'null'); } catch(e) {}

  var data = {
    request_reference: byQuery('request_reference') || (requestData && requestData.request_reference) || '',
    source_title: byQuery('source_title') || (requestData && requestData.source_title) || '',
    source_type: byQuery('source_type') || (requestData && requestData.source_type) || '',
    requested_mode: byQuery('requested_mode') || (requestData && requestData.requested_mode) || ''
  };

  if (ref && data.request_reference) ref.textContent = data.request_reference;
  if (source && data.source_title) source.textContent = data.source_title;
  if (mode && data.requested_mode) mode.textContent = data.requested_mode.charAt(0).toUpperCase() + data.requested_mode.slice(1);
  if (resumeLink && requestData) {
    var focus = Array.isArray(requestData.focus) && requestData.focus.length ? requestData.focus[0] : '';
    var url = '/plan';
    var params = [];
    if (requestData.requested_mode) params.push('mode=' + encodeURIComponent(requestData.requested_mode));
    if (focus) params.push('focus=' + encodeURIComponent(focus));
    if (requestData.source_type) params.push('source_type=' + encodeURIComponent(requestData.source_type));
    if (requestData.source_title) params.push('source_title=' + encodeURIComponent(requestData.source_title));
    if (requestData.source_url) params.push('source_url=' + encodeURIComponent(requestData.source_url));
    if (params.length) url += '?' + params.join('&');
    resumeLink.href = url;
  }
  if (emailLink && data.request_reference) {
    var base = emailLink.getAttribute('href') || '';
    var joiner = base.indexOf('?') === -1 ? '?' : '&';
    emailLink.href = base + joiner + 'subject=' + encodeURIComponent(data.request_reference + ' follow-up');
  }
  if (copyBtn && ref) {
    copyBtn.addEventListener('click', function(){
      var text = ref.textContent || '';
      if (!text) return;
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text);
      }
      copyBtn.textContent = 'Copied';
      setTimeout(function(){ copyBtn.textContent = 'Copy reference'; }, 1600);
    });
  }
})();


// v25 request packet continuity
(function(){
  var form = document.getElementById('luxury-plan-form');
  if (!form) return;
  var requestKey = 'mykonos_nocturne_last_request_v25';
  var requestCareLink = document.getElementById('successRequestCareLink');
  var packetLink = document.getElementById('successRequestPacketLink');

  function selectedFocus(){
    var vals = [];
    form.querySelectorAll('.focus-chip input:checked').forEach(function(input){ vals.push(input.value); });
    return vals;
  }

  function buildPacket(){
    return {
      request_reference: (form.querySelector('#request_reference') || {}).value || '',
      full_name: ((form.querySelector('[name="full_name"]') || {}).value || '').trim(),
      email: ((form.querySelector('[name="email"]') || {}).value || '').trim(),
      phone: ((form.querySelector('[name="phone"]') || {}).value || '').trim(),
      guests: ((form.querySelector('[name="guests"]') || {}).value || '').trim(),
      arrival_date: ((form.querySelector('[name="arrival_date"]') || {}).value || '').trim(),
      departure_date: ((form.querySelector('[name="departure_date"]') || {}).value || '').trim(),
      arrival_window: ((form.querySelector('[name="arrival_window"]') || {}).value || '').trim(),
      travel_style: ((form.querySelector('[name="travel_style"]') || {}).value || '').trim(),
      occasion_type: ((form.querySelector('[name="occasion_type"]') || {}).value || '').trim(),
      group_composition: ((form.querySelector('[name="group_composition"]') || {}).value || '').trim(),
      contact_preference: ((form.querySelector('[name="contact_preference"]') || {}).value || '').trim(),
      dietary_needs: ((form.querySelector('[name="dietary_needs"]') || {}).value || '').trim(),
      details: ((form.querySelector('[name="details"]') || {}).value || '').trim(),
      focus: selectedFocus(),
      requested_mode: (form.querySelector('#requested_mode') || {}).value || '',
      source_type: (form.querySelector('#source_type') || {}).value || '',
      source_title: (form.querySelector('#source_title') || {}).value || '',
      source_url: (form.querySelector('#source_url') || {}).value || '',
      submitted_at: new Date().toISOString()
    };
  }

  var oldSuccess = window.NocturnePlan && window.NocturnePlan.onSuccess;
  if (typeof oldSuccess === 'function') {
    window.NocturnePlan.onSuccess = function(){
      var packet = buildPacket();
      try { localStorage.setItem(requestKey, JSON.stringify(packet)); localStorage.setItem('mykonos_nocturne_last_request_v24', JSON.stringify(packet)); } catch(e) {}
      var qs = '?request_reference=' + encodeURIComponent(packet.request_reference || '') +
        '&source_title=' + encodeURIComponent(packet.source_title || '') +
        '&source_type=' + encodeURIComponent(packet.source_type || '') +
        '&requested_mode=' + encodeURIComponent(packet.requested_mode || '');
      if (requestCareLink) requestCareLink.href = '/request-care' + qs;
      if (packetLink) packetLink.href = '/request-packet' + qs;
      oldSuccess();
    };
  }
})();

(function(){
  if (!document.body.classList.contains('page-request-care')) return;
  var requestKey = 'mykonos_nocturne_last_request_v25';
  var packetLink = document.getElementById('requestCarePacketLink');
  var emailLink = document.getElementById('requestCareEmailLink');
  var requestData = null;
  try { requestData = JSON.parse(localStorage.getItem(requestKey) || 'null'); } catch(e) {}
  if (packetLink && requestData) {
    packetLink.href = '/request-packet?request_reference=' + encodeURIComponent(requestData.request_reference || '') +
      '&source_title=' + encodeURIComponent(requestData.source_title || '') +
      '&source_type=' + encodeURIComponent(requestData.source_type || '') +
      '&requested_mode=' + encodeURIComponent(requestData.requested_mode || '');
  }
  if (emailLink && requestData && requestData.request_reference) {
    var body = [
      'Reference: ' + (requestData.request_reference || ''),
      'Source: ' + (requestData.source_title || 'General planning flow'),
      'Mode: ' + (requestData.requested_mode || 'detailed'),
      ''
    ].join('\n');
    emailLink.href = 'mailto:' + ((emailLink.href.split(':')[1] || '').split('?')[0] || 'mykonos@cabnet.app') +
      '?subject=' + encodeURIComponent((requestData.request_reference || 'Request') + ' follow-up') +
      '&body=' + encodeURIComponent(body);
  }
})();

(function(){
  if (!document.body.classList.contains('page-request-packet')) return;
  var requestKey = 'mykonos_nocturne_last_request_v25';
  var data = null;
  try { data = JSON.parse(localStorage.getItem(requestKey) || 'null'); } catch(e) {}
  try {
    var params = new URLSearchParams(window.location.search);
    data = Object.assign({}, data || {}, {
      request_reference: params.get('request_reference') || (data && data.request_reference) || '',
      source_title: params.get('source_title') || (data && data.source_title) || '',
      source_type: params.get('source_type') || (data && data.source_type) || '',
      requested_mode: params.get('requested_mode') || (data && data.requested_mode) || ''
    });
  } catch(e) { data = data || {}; }
  if (!data) data = {};

  function setText(id, value){ var el = document.getElementById(id); if (el && value) el.textContent = value; }
  function urgencyHint(arrivalDate){
    if (!arrivalDate) return 'Date not supplied';
    var arrival = new Date(arrivalDate + 'T00:00:00');
    if (isNaN(arrival.getTime())) return 'Date supplied - verify manually';
    var now = new Date(); now.setHours(0,0,0,0);
    var days = Math.round((arrival.getTime() - now.getTime()) / 86400000);
    if (days <= 14) return 'High - arrival within 14 days';
    if (days <= 45) return 'Active planning window';
    return 'Standard planning horizon';
  }
  function packetText(packet){
    return [
      'REQUEST PACKET',
      'Reference: ' + (packet.request_reference || ''),
      'Guest: ' + ((packet.full_name || 'Guest') + (packet.email ? ' · ' + packet.email : '') + (packet.phone ? ' · ' + packet.phone : '')),
      'Timing: ' + ([packet.arrival_date, packet.departure_date].filter(Boolean).join(' → ') || 'Not supplied'),
      'Guests: ' + (packet.guests || 'Flexible'),
      'Focus: ' + ((packet.focus && packet.focus.length) ? packet.focus.join(', ') : (packet.source_title || 'General planning flow')),
      'Mode: ' + (packet.requested_mode || 'detailed'),
      'Source: ' + (packet.source_title || 'General planning flow'),
      'Travel Style: ' + (packet.travel_style || 'Not supplied'),
      'Occasion: ' + (packet.occasion_type || 'Not supplied'),
      'Group Composition: ' + (packet.group_composition || 'Not supplied'),
      'Dietary Needs: ' + (packet.dietary_needs || 'Not supplied'),
      'Contact Preference: ' + (packet.contact_preference || 'Not supplied'),
      '',
      'DETAILS',
      packet.details || 'No additional stay brief supplied.'
    ].join('\n');
  }

  setText('packetReference', data.request_reference || 'Waiting for request data');
  setText('packetOperatorReference', data.request_reference || 'Keep this with every follow-up.');
  setText('packetGuest', ((data.full_name || 'Guest details pending') + (data.email ? ' · ' + data.email : '') + (data.phone ? ' · ' + data.phone : '')));
  setText('packetTiming', ([data.arrival_date, data.departure_date].filter(Boolean).join(' → ') || (data.arrival_window || 'Trip timing pending')));
  setText('packetFocus', ((data.focus && data.focus.length) ? data.focus.join(', ') : (data.source_title || 'No focus selected yet')));
  setText('packetMode', data.requested_mode ? data.requested_mode.charAt(0).toUpperCase() + data.requested_mode.slice(1) : 'Detailed');
  setText('packetSource', data.source_title || 'General planning flow');
  setText('packetFollowup', data.contact_preference || 'Email concierge or reopen the brief');
  setText('packetOperatorIntent', ((data.focus && data.focus.length) ? data.focus.join(', ') : (data.source_title || 'General luxury stay planning')));
  setText('packetOperatorPriority', urgencyHint(data.arrival_date));
  setText('packetHeadline', data.source_title ? ('Built from ' + data.source_title + ' and ready for follow-up.') : 'A concise handoff view of the latest enquiry.');

  var textarea = document.getElementById('requestPacketText');
  if (textarea) textarea.value = packetText(data);

  var resumeUrl = '/plan';
  var params = [];
  if (data.requested_mode) params.push('mode=' + encodeURIComponent(data.requested_mode));
  if (data.source_type) params.push('source_type=' + encodeURIComponent(data.source_type));
  if (data.source_title) params.push('source_title=' + encodeURIComponent(data.source_title));
  if (data.source_url) params.push('source_url=' + encodeURIComponent(data.source_url));
  if (data.focus && data.focus[0]) params.push('focus=' + encodeURIComponent(data.focus[0]));
  if (params.length) resumeUrl += '?' + params.join('&');

  ['requestPacketResumeLink','requestPacketResumeTop'].forEach(function(id){
    var el = document.getElementById(id); if (el) el.href = resumeUrl;
  });

  ['requestPacketEmailBtn','requestPacketEmailTop'].forEach(function(id){
    var el = document.getElementById(id); if (!el) return;
    var addr = ((el.getAttribute('href') || '').split(':')[1] || '').split('?')[0] || 'mykonos@cabnet.app';
    el.href = 'mailto:' + addr + '?subject=' + encodeURIComponent((data.request_reference || 'Request packet') + ' handoff') + '&body=' + encodeURIComponent(packetText(data));
  });

  var copyBtn = document.getElementById('requestPacketCopyBtn');
  if (copyBtn && textarea) {
    copyBtn.addEventListener('click', function(){
      var text = textarea.value || '';
      if (!text) return;
      if (navigator.clipboard && navigator.clipboard.writeText) navigator.clipboard.writeText(text);
      copyBtn.textContent = 'Copied';
      setTimeout(function(){ copyBtn.textContent = 'Copy packet'; }, 1600);
    });
  }
})();
