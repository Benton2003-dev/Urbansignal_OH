@extends('layouts.app')
@section('title', 'Accueil')

@push('styles')
<style>
/* ── Google Fonts ── */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Outfit:wght@300;400;500;600&display=swap');

/* ── Design Tokens ── */
:root {
  --sand:   #F4F7FC;
  --navy:   #1B2F6E;
  --royal:  #2952A3;
  --sky:    #5B9BD5;
  --gold:   #E8B84B;
  --ink:    #0D1B3E;
  --smoke:  #6B7FA3;
  --mist:   #EBF1FA;
  --line:   rgba(27,47,110,.09);
  --white:  #FFFFFF;

  --forest: var(--navy);
  --olive:  var(--royal);
  --clay:   var(--gold);
  --amber:  var(--gold);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--sand); font-family: 'Outfit', sans-serif; }

/* ════ HERO ════ */
.us-hero {
  position: relative;
  background: var(--forest);
  min-height: 90vh;
  display: flex;
  align-items: center;
  overflow: hidden;
}

.us-hero__grain {
  position: absolute; inset: 0; pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23g)' opacity='0.07'/%3E%3C/svg%3E");
  opacity: .45;
}

.us-hero__panel {
  position: absolute;
  top: 0; right: 0;
  width: 42%; height: 100%;
  background: var(--olive);
  clip-path: polygon(14% 0, 100% 0, 100% 100%, 0% 100%);
  opacity: .18;
}

.us-hero__dots {
  position: absolute;
  top: 0; right: 0;
  width: 42%; height: 100%;
  background-image: radial-gradient(circle, rgba(255,255,255,.13) 1px, transparent 1px);
  background-size: 22px 22px;
  clip-path: polygon(14% 0, 100% 0, 100% 100%, 0% 100%);
  pointer-events: none;
}

.us-hero__ghost {
  position: absolute;
  bottom: -1.5rem; right: -1rem;
  font-family: 'Montserrat', sans-serif;
  font-size: clamp(6rem, 15vw, 13rem);
  font-weight: 900;
  color: rgba(255,255,255,.025);
  line-height: 1;
  pointer-events: none;
  user-select: none;
  white-space: nowrap;
}

.us-hero__inner {
  position: relative; z-index: 2;
  max-width: 1200px;
  width: 100%;
  margin: 0 auto;
  padding: 5.5rem 2rem 8rem;
}

.us-hero__content { max-width: 580px; }

@keyframes us-slideUp {
  from { opacity: 0; transform: translateY(30px); }
  to   { opacity: 1; transform: translateY(0); }
}
.us-hero__content > * {
  animation: us-slideUp .8s cubic-bezier(.22,1,.36,1) both;
}
.us-hero__content > *:nth-child(1) { animation-delay: .08s; }
.us-hero__content > *:nth-child(2) { animation-delay: .20s; }
.us-hero__content > *:nth-child(3) { animation-delay: .34s; }
.us-hero__content > *:nth-child(4) { animation-delay: .46s; }

.us-badge {
  display: inline-flex; align-items: center; gap: .55rem;
  border: 1px solid rgba(255,255,255,.18);
  border-radius: 999px;
  padding: .3rem .9rem .3rem .5rem;
  font-size: .73rem; font-weight: 500;
  letter-spacing: .1em; text-transform: uppercase;
  color: rgba(255,255,255,.6);
  margin-bottom: 2rem;
}
.us-badge__dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #6EE7A0;
  animation: us-breathe 2.4s ease-in-out infinite;
}
@keyframes us-breathe {
  0%,100% { transform: scale(1); opacity: 1; }
  50%      { transform: scale(.65); opacity: .45; }
}

.us-hero h1 {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(2.5rem, 5.5vw, 4rem);
  line-height: 1.07;
  color: #fff;
  letter-spacing: -.015em;
  margin-bottom: 1.5rem;
}
.us-hero h1 em {
  font-style: italic;
  color: var(--amber);
}

.us-hero__desc {
  font-size: 1.02rem;
  line-height: 1.75;
  color: rgba(255,255,255,.52);
  font-weight: 300;
  margin-bottom: 2.75rem;
}

.us-hero__actions { display: flex; flex-wrap: wrap; gap: .875rem; }

.us-btn-primary {
  display: inline-flex; align-items: center; gap: .5rem;
  background: var(--clay);
  color: #fff;
  font-family: 'Outfit', sans-serif;
  font-weight: 600; font-size: .9rem;
  padding: .85rem 1.65rem;
  border-radius: 12px;
  text-decoration: none;
  box-shadow: 0 6px 28px rgba(201,107,53,.42);
  transition: transform .22s, box-shadow .22s, background .18s;
}
.us-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 36px rgba(201,107,53,.54);
  background: #D97840;
}

.us-btn-ghost {
  display: inline-flex; align-items: center; gap: .5rem;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.16);
  color: rgba(255,255,255,.78);
  font-family: 'Outfit', sans-serif;
  font-weight: 500; font-size: .9rem;
  padding: .85rem 1.65rem;
  border-radius: 12px;
  text-decoration: none;
  transition: background .18s, border-color .18s;
}
.us-btn-ghost:hover {
  background: rgba(255,255,255,.13);
  border-color: rgba(255,255,255,.3);
  color: #fff;
}

.us-hero__scroll {
  position: absolute;
  bottom: 2.5rem; left: 50%;
  transform: translateX(-50%);
  display: flex; flex-direction: column; align-items: center; gap: .4rem;
  color: rgba(255,255,255,.22);
  font-size: .68rem; letter-spacing: .14em; text-transform: uppercase;
  z-index: 3;
}
.us-hero__scroll-bar {
  width: 1px; height: 36px;
  background: linear-gradient(to bottom, rgba(255,255,255,.3), transparent);
  animation: us-scrollBar 2.2s ease-in-out infinite;
}
@keyframes us-scrollBar {
  0%   { transform: scaleY(0); transform-origin: top; }
  50%  { transform: scaleY(1); transform-origin: top; }
  51%  { transform: scaleY(1); transform-origin: bottom; }
  100% { transform: scaleY(0); transform-origin: bottom; }
}

.us-hero__wave {
  position: absolute; bottom: 0; left: 0; right: 0;
  line-height: 0; z-index: 3;
}

/* ════ STATS ════ */
.us-stats {
  max-width: 1100px;
  margin: -3.5rem auto 0;
  padding: 0 2rem 5rem;
  position: relative; z-index: 10;
}

.us-stats__card {
  background: var(--white);
  border-radius: 22px;
  box-shadow: 0 24px 70px rgba(15,31,23,.13);
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  overflow: hidden;
}
@media(min-width:700px){ .us-stats__card { grid-template-columns: repeat(4, 1fr); } }

.us-stat {
  padding: 2rem 1.75rem;
  border-right: 1px solid var(--line);
  border-bottom: 1px solid var(--line);
  position: relative;
  transition: background .2s;
}
.us-stat:hover { background: #FAFDF9; }
.us-stat:nth-child(2n) { border-right: none; }
@media(min-width:700px){
  .us-stat:nth-child(2n) { border-right: 1px solid var(--line); }
  .us-stat:last-child { border-right: none; }
  .us-stat { border-bottom: none; }
}
.us-stat::before {
  content: '';
  position: absolute; left: 0;
  top: 22%; bottom: 22%;
  width: 3px; border-radius: 0 3px 3px 0;
  background: var(--c, var(--smoke));
}

.us-stat__num {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
  font-size: 2.75rem;
  line-height: 1;
  color: var(--ink);
  margin-bottom: .4rem;
  letter-spacing: -.03em;
}

.us-stat__label {
  font-size: .75rem; font-weight: 500;
  letter-spacing: .08em; text-transform: uppercase;
  color: var(--smoke);
}

/* ════ DERNIERS SIGNALEMENTS ════ */
.us-recent {
  background: var(--mist);
  padding: 5rem 2rem;
}
.us-recent__inner { max-width: 1100px; margin: 0 auto; }

.us-recent__head {
  display: flex; align-items: flex-end;
  justify-content: space-between;
  flex-wrap: wrap; gap: 1rem;
  margin-bottom: 2.5rem;
}

.us-recent__link {
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .82rem; font-weight: 600;
  color: var(--royal); text-decoration: none;
  transition: color .18s;
}
.us-recent__link:hover { color: var(--navy); }

.us-recent__grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}
@media(min-width:640px){ .us-recent__grid { grid-template-columns: repeat(2,1fr); } }
@media(min-width:960px){ .us-recent__grid { grid-template-columns: repeat(3,1fr); } }

.us-report-card {
  background: var(--white);
  border: 1px solid var(--line);
  border-radius: 16px;
  padding: 1.35rem 1.25rem;
  transition: transform .22s, box-shadow .22s;
}
.us-report-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 36px rgba(27,47,110,.1);
}

.us-report-card__top {
  display: flex; align-items: center;
  justify-content: space-between;
  gap: .5rem; margin-bottom: .85rem;
}

.us-report-card__cat {
  font-size: .68rem; font-weight: 700;
  letter-spacing: .07em; text-transform: uppercase;
  color: var(--cc, var(--royal));
  background: color-mix(in srgb, var(--cc, var(--royal)) 12%, transparent);
  padding: .2rem .6rem; border-radius: 5px;
  white-space: nowrap; overflow: hidden;
  text-overflow: ellipsis; max-width: 140px;
}

.us-report-card__status {
  font-size: .65rem; font-weight: 700;
  letter-spacing: .06em; text-transform: uppercase;
  padding: .2rem .6rem; border-radius: 5px;
  white-space: nowrap;
  border: 1.5px solid currentColor;
}
.us-report-card__status--submitted  { color: var(--smoke); }
.us-report-card__status--validated  { color: #2563EB; }
.us-report-card__status--in_progress{ color: var(--gold); }
.us-report-card__status--resolved   { color: var(--royal); }

.us-report-card__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: .95rem;
  color: var(--ink); line-height: 1.3;
  margin-bottom: .75rem;
}

.us-report-card__meta {
  display: flex; align-items: center;
  justify-content: space-between;
  font-size: .72rem; color: var(--smoke);
  font-weight: 300;
}
.us-report-card__meta span {
  display: flex; align-items: center; gap: .3rem;
}

/* ════ TÉMOIGNAGES ════ */
.us-testimonials { padding: 5rem 2rem; background: var(--white); }
.us-testimonials__inner { max-width: 1100px; margin: 0 auto; }

.us-testimonials__grid {
  display: grid; grid-template-columns: 1fr; gap: 1.25rem;
}
@media(min-width:768px){ .us-testimonials__grid { grid-template-columns: repeat(3,1fr); } }

.us-testimonial {
  background: var(--sand);
  border: 1px solid var(--line);
  border-radius: 18px;
  padding: 1.75rem 1.5rem;
  position: relative;
  transition: transform .22s, box-shadow .22s;
}
.us-testimonial:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 36px rgba(27,47,110,.08);
}

.us-testimonial__quote {
  font-family: 'Montserrat', sans-serif;
  font-size: 4rem; font-weight: 900; line-height: 1;
  color: var(--navy); opacity: .12;
  position: absolute; top: .75rem; right: 1.25rem;
  user-select: none;
}

.us-testimonial__text {
  font-size: .88rem; line-height: 1.7;
  color: var(--ink); font-weight: 300;
  margin-bottom: 1.25rem;
  font-style: italic;
}

.us-testimonial__author {
  display: flex; align-items: center; gap: .75rem;
}

.us-testimonial__avatar {
  width: 38px; height: 38px; border-radius: 50%;
  background: var(--navy);
  color: #fff;
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 1rem;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}

.us-testimonial__name {
  font-size: .85rem; font-weight: 600; color: var(--ink);
}
.us-testimonial__arr {
  font-size: .72rem; color: var(--smoke); font-weight: 300;
}

/* ════ HOW IT WORKS ════ */
.us-how {
  max-width: 1100px;
  margin: 0 auto;
  padding: 2rem 2rem 6rem;
}

.us-eyebrow {
  font-size: .72rem; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--clay);
  display: block; margin-bottom: .65rem;
}

.us-heading {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(1.9rem, 3.5vw, 2.8rem);
  color: var(--ink);
  letter-spacing: -.02em; line-height: 1.1;
}

.us-subtext {
  font-size: .96rem; line-height: 1.7;
  color: var(--smoke);
  font-weight: 300;
  max-width: 460px;
  margin: .9rem auto 0;
}

.us-steps {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.25rem;
  margin-top: 3.5rem;
}
@media(min-width:680px){ .us-steps { grid-template-columns: repeat(2,1fr); } }
@media(min-width:980px){ .us-steps { grid-template-columns: repeat(4,1fr); } }

.us-step {
  background: var(--white);
  border: 1px solid rgba(15,31,23,.07);
  border-radius: 20px;
  padding: 1.75rem 1.5rem;
  position: relative;
  overflow: hidden;
  transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s;
}
.us-step::after {
  content: attr(data-num);
  position: absolute; bottom: -1.4rem; right: .65rem;
  font-family: 'Montserrat', sans-serif;
  font-size: 6rem; font-weight: 900;
  color: rgba(15,31,23,.04);
  line-height: 1; pointer-events: none; user-select: none;
}
.us-step:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 50px rgba(27,47,110,.12);
}

.us-step__icon {
  width: 48px; height: 48px;
  border-radius: 13px;
  background: var(--mist);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.25rem;
  transition: background .25s;
}
.us-step:hover .us-step__icon { background: var(--royal); }
.us-step:hover .us-step__icon svg { color: #fff !important; }

.us-step__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 1.05rem;
  color: var(--ink); margin-bottom: .45rem;
}

.us-step__desc {
  font-size: .85rem; line-height: 1.65;
  color: var(--smoke); font-weight: 300;
}

/* ════ TRACK ════ */
.us-track {
  background: var(--forest);
  position: relative; overflow: hidden;
  padding: 6rem 2rem;
}

.us-track::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23g)' opacity='0.05'/%3E%3C/svg%3E");
  pointer-events: none;
}

.us-track::after {
  content: '';
  position: absolute; top: 50%; right: -8%;
  transform: translateY(-50%);
  width: 520px; height: 520px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(229,160,58,.09) 0%, transparent 65%);
  pointer-events: none;
}

.us-track__inner {
  position: relative; z-index: 2;
  max-width: 540px; margin: 0 auto; text-align: center;
}

.us-track__eyebrow {
  font-size: .72rem; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--amber); display: block; margin-bottom: .65rem;
}

.us-track__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(1.8rem, 4vw, 2.6rem);
  color: #fff; letter-spacing: -.02em;
  margin-bottom: .85rem; line-height: 1.1;
}

.us-track__sub {
  font-size: .94rem; line-height: 1.7;
  color: rgba(255,255,255,.43);
  font-weight: 300; margin-bottom: 2.5rem;
}

.us-track__form { display: flex; gap: .75rem; }

.us-track__input {
  flex: 1;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.14);
  border-radius: 12px;
  padding: .9rem 1.2rem;
  color: #fff;
  font-family: 'Outfit', sans-serif; font-size: .9rem;
  outline: none;
  transition: border-color .2s, background .2s;
}
.us-track__input::placeholder { color: rgba(255,255,255,.27); }
.us-track__input:focus {
  border-color: var(--amber);
  background: rgba(255,255,255,.1);
}

.us-track__btn {
  background: var(--clay); color: #fff;
  font-family: 'Outfit', sans-serif;
  font-weight: 600; font-size: .9rem;
  padding: .9rem 1.6rem;
  border-radius: 12px; border: none; cursor: pointer;
  white-space: nowrap;
  box-shadow: 0 4px 20px rgba(201,107,53,.35);
  transition: background .18s, transform .2s;
}
.us-track__btn:hover { background: #D97840; transform: translateY(-1px); }

/* ════ CTA ════ */
.us-cta {
  padding: 4rem 1rem;
  text-align: center;
  position: relative; overflow: hidden;
}

.us-cta::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 65% 75% at 50% 50%, rgba(41,82,163,.08) 0%, transparent 68%);
  pointer-events: none;
}

.us-cta__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(2.1rem, 5vw, 3.5rem);
  color: var(--ink);
  letter-spacing: -.03em; line-height: 1.08;
  margin-bottom: 1.2rem;
}
.us-cta__title em { font-style: italic; color: var(--olive); }

.us-cta__sub {
  font-size: .98rem; line-height: 1.75;
  color: var(--smoke);
  max-width: 430px;
  margin: 0 auto 2.75rem;
  font-weight: 300;
}

.us-cta__btn {
  display: inline-flex; align-items: center; gap: .6rem;
  background: var(--forest); color: #fff;
  font-family: 'Outfit', sans-serif;
  font-weight: 600; font-size: .98rem;
  padding: 1rem 2.25rem;
  border-radius: 14px; text-decoration: none;
  box-shadow: 0 10px 42px rgba(27,47,110,.26);
  transition: transform .22s, box-shadow .22s, background .18s;
}
.us-cta__btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 18px 52px rgba(27,47,110,.34);
  background: #1a2b62;
}

/* ══════════════════════════════════════════════
   RESPONSIVE — MOBILE (≤ 480px)
══════════════════════════════════════════════ */
@media (max-width: 480px) {

  /* ── HERO ── */
  .us-hero {
    min-height: 100svh;
    align-items: flex-start;
  }

  .us-hero__panel,
  .us-hero__dots {
    width: 100%;
    clip-path: polygon(0 70%, 100% 55%, 100% 100%, 0% 100%);
    opacity: .10;
  }

  .us-hero__ghost {
    font-size: 4.5rem;
    bottom: 5rem;
    right: -0.5rem;
    opacity: .6;
  }

  .us-hero__inner {
    padding: 4.5rem 1.25rem 7rem;
  }

  .us-hero__content {
    max-width: 100%;
  }

  .us-badge {
    font-size: .65rem;
    padding: .25rem .75rem .25rem .45rem;
    margin-bottom: 1.5rem;
  }

  .us-hero h1 {
    font-size: clamp(1.9rem, 8vw, 2.6rem);
    margin-bottom: 1.15rem;
    line-height: 1.1;
  }

  .us-hero__desc {
    font-size: .9rem;
    line-height: 1.7;
    margin-bottom: 2rem;
  }

  .us-hero__actions {
    flex-direction: column;
    gap: .75rem;
  }

  .us-btn-primary,
  .us-btn-ghost {
    width: 100%;
    justify-content: center;
    padding: .95rem 1.25rem;
    font-size: .88rem;
  }

  .us-hero__scroll { display: none; }

  /* ── STATS ── */
  .us-stats {
    margin: -2rem auto 0;
    padding: 0 1rem 3.5rem;
  }

  .us-stats__card {
    border-radius: 16px;
    grid-template-columns: repeat(2, 1fr);
  }

  .us-stat {
    padding: 1.25rem 1rem;
  }

  .us-stat__num {
    font-size: 2rem;
  }

  .us-stat__label {
    font-size: .67rem;
  }

  /* ── RECENT ── */
  .us-recent {
    padding: 3.5rem 1.25rem;
  }

  .us-recent__head {
    flex-direction: column;
    align-items: flex-start;
    gap: .75rem;
    margin-bottom: 1.75rem;
  }

  .us-heading {
    font-size: clamp(1.6rem, 6vw, 2rem);
  }

  /* ── TESTIMONIALS ── */
  .us-testimonials {
    padding: 3.5rem 1.25rem;
  }

  .us-testimonial {
    padding: 1.5rem 1.25rem;
  }

  /* ── HOW ── */
  .us-how {
    padding: 2rem 1.25rem 4rem;
  }

  .us-step {
    padding: 1.5rem 1.25rem;
  }

  .us-step::after {
    font-size: 4.5rem;
  }

  /* ── TRACK ── */
  .us-track {
    padding: 4rem 1.25rem;
  }

  .us-track__form {
    flex-direction: column;
    gap: .65rem;
  }

  .us-track__btn {
    width: 100%;
    padding: .95rem 1.25rem;
  }

  /* ── CTA ── */
  .us-cta {
    padding: 3.5rem 1.25rem;
  }

  .us-cta__btn {
    width: 100%;
    justify-content: center;
    padding: 1rem 1.25rem;
    font-size: .9rem;
  }
}

/* ══════════════════════════════════════════════
   RESPONSIVE — TABLETTE (481px – 768px)
══════════════════════════════════════════════ */
@media (min-width: 481px) and (max-width: 768px) {

  /* ── HERO ── */
  .us-hero {
    min-height: 85vh;
  }

  .us-hero__panel,
  .us-hero__dots {
    width: 55%;
    opacity: .14;
  }

  .us-hero__ghost {
    font-size: clamp(5rem, 12vw, 8rem);
  }

  .us-hero__inner {
    padding: 5rem 1.75rem 7.5rem;
  }

  .us-hero__content {
    max-width: 100%;
  }

  .us-hero h1 {
    font-size: clamp(2.1rem, 5.5vw, 3rem);
  }

  .us-hero__desc {
    font-size: .95rem;
  }

  .us-hero__actions {
    flex-wrap: nowrap;
    gap: .75rem;
  }

  .us-btn-primary,
  .us-btn-ghost {
    flex: 1;
    justify-content: center;
    padding: .9rem 1.1rem;
    font-size: .85rem;
  }

  /* ── STATS ── */
  .us-stats {
    margin: -2.5rem auto 0;
    padding: 0 1.5rem 4rem;
  }

  .us-stat {
    padding: 1.5rem 1.25rem;
  }

  .us-stat__num {
    font-size: 2.2rem;
  }

  /* ── RECENT ── */
  .us-recent {
    padding: 4rem 1.5rem;
  }

  /* ── TESTIMONIALS ── */
  .us-testimonials {
    padding: 4rem 1.5rem;
  }

  .us-testimonials__grid {
    grid-template-columns: 1fr;
  }

  /* ── HOW ── */
  .us-how {
    padding: 2rem 1.5rem 5rem;
  }

  /* ── TRACK ── */
  .us-track {
    padding: 5rem 1.5rem;
  }

  .us-track__form {
    flex-direction: column;
    gap: .65rem;
  }

  .us-track__btn {
    width: 100%;
    padding: .95rem 1.25rem;
  }

  .us-track__inner {
    max-width: 100%;
  }

  /* ── CTA ── */
  .us-cta {
    padding: 3.5rem 1.5rem;
  }

  .us-cta__btn {
    font-size: .92rem;
    padding: .95rem 1.75rem;
  }
}

/* ══════════════════════════════════════════════
   RESPONSIVE — GRANDE TABLETTE (769px – 1024px)
══════════════════════════════════════════════ */
@media (min-width: 769px) and (max-width: 1024px) {

  .us-hero__inner {
    padding: 5.5rem 2rem 8rem;
  }

  .us-hero__content {
    max-width: 520px;
  }

  .us-stats {
    padding: 0 1.5rem 5rem;
  }

  .us-recent {
    padding: 4.5rem 1.5rem;
  }

  .us-testimonials {
    padding: 4.5rem 1.5rem;
  }

  .us-how {
    padding: 2rem 1.5rem 5.5rem;
  }

  .us-track {
    padding: 5.5rem 2rem;
  }

  .us-track__form {
    flex-direction: row;
  }

  .us-cta {
    padding: 4rem 2rem;
  }
}
</style>
@endpush

@section('content')

{{-- ═════ HERO ═════ --}}
<section class="us-hero">
    <div class="us-hero__grain"></div>
    <div class="us-hero__panel"></div>
    <div class="us-hero__dots"></div>
    <span class="us-hero__ghost">Ouidah</span>

    <div class="us-hero__inner">
        <div class="us-hero__content">

            <div class="us-badge">
                <span class="us-badge__dot"></span>
                Commune de Ouidah — Bénin
            </div>

            <h1>
                Signalez les pannes urbaines<br>
                de <em>Ouidah</em>
            </h1>

            <p class="us-hero__desc">
                UrbanSignal permet aux citoyens de signaler facilement les nids-de-poule, routes cassées, fuite d'eau, caniveaux bouchés  et autres problèmes urbains. La Mairie intervient plus rapidement grâce à votre signalement.
            </p>

            <div class="us-hero__actions">
                @auth
                    <a href="{{ route('citizen.reports.create') }}" class="us-btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Faire un signalement
                    </a>
                    <a href="{{ route('citizen.dashboard') }}" class="us-btn-ghost">
                        Mes signalements
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="us-btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Créer un compte gratuitement
                    </a>
                    <a href="{{ route('track') }}" class="us-btn-ghost">
                        Suivre mon ticket
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="us-hero__scroll">
        <div class="us-hero__scroll-bar"></div>
        Défiler
    </div>

    <div class="us-hero__wave">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 80L1440 80L1440 35C1060 78 700 8 380 38C175 57 65 20 0 35Z" fill="#F5EFE4"/>
        </svg>
    </div>
</section>

{{-- ═════ STATS ═════ --}}
<section class="us-stats">
    <div class="us-stats__card">
        <div class="us-stat" style="--c: var(--olive)">
            <div class="us-stat__num" style="color: var(--forest)">{{ $stats['total'] }}</div>
            <div class="us-stat__label">Total signalements</div>
        </div>
        <div class="us-stat" style="--c: var(--clay)">
            <div class="us-stat__num" style="color: var(--clay)">{{ $stats['resolved'] }}</div>
            <div class="us-stat__label">Problèmes résolus</div>
        </div>
        <div class="us-stat" style="--c: var(--olive)">
            <div class="us-stat__num" style="color: var(--forest)">{{ $stats['in_progress'] }}</div>
            <div class="us-stat__label">En cours de traitement</div>
        </div>
        <div class="us-stat" style="--c: var(--clay)">
            <div class="us-stat__num" style="color: var(--clay)">{{ $stats['submitted'] }}</div>
            <div class="us-stat__label">En attente</div>
        </div>
    </div>
</section>

{{-- ═════ DERNIERS SIGNALEMENTS ═════ --}}
<section class="us-recent">
    <div class="us-recent__inner">
        <div class="us-recent__head">
            <div>
                <span class="us-eyebrow">Activité récente</span>
                <h2 class="us-heading">Derniers signalements</h2>
            </div>
            <a href="{{ route('track') }}" class="us-recent__link">
                Suivre le mien
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="us-recent__grid">
            @foreach($recentReports as $report)
            <div class="us-report-card">
                <div class="us-report-card__top">
                    <span class="us-report-card__cat" style="--cc: {{ $report->category->color }}">
                        {{ $report->category->name }}
                    </span>
                    <span class="us-report-card__status us-report-card__status--{{ $report->status }}">
                        {{ $report->status_label }}
                    </span>
                </div>
                <h3 class="us-report-card__title">{{ Str::limit($report->title, 55) }}</h3>
                <div class="us-report-card__meta">
                    <span>
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $report->arrondissement->name ?? 'Ouidah' }}
                    </span>
                    <span>{{ $report->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═════ TÉMOIGNAGES ═════ --}}
<section class="us-testimonials">
    <div class="us-testimonials__inner">
        <div style="text-align:center; margin-bottom:3rem">
            <span class="us-eyebrow">Ils témoignent</span>
            <h2 class="us-heading">Ce que disent les citoyens</h2>
        </div>
        <div class="us-testimonials__grid">
            @php
            $testimonials = [
                ['name'=>'Adjoavi M.', 'arr'=>'Ouidah II', 'text'=>'En 3 jours après mon signalement, la mairie est intervenue sur le nid-de-poule devant chez moi. Je n\'y croyais pas !', 'initial'=>'A'],
                ['name'=>'Kokou F.', 'arr'=>'Pahou', 'text'=>'La plateforme est simple à utiliser, même sans être expert. J\'ai fait mon signalement en moins de 2 minutes depuis mon téléphone.', 'initial'=>'K'],
                ['name'=>'Bénédicte A.', 'arr'=>'Savi', 'text'=>'Pouvoir suivre l\'avancement avec un numéro de ticket, c\'est rassurant. On sait que notre signalement est pris en compte.', 'initial'=>'B'],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="us-testimonial">
                <div class="us-testimonial__quote">"</div>
                <p class="us-testimonial__text">{{ $t['text'] }}</p>
                <div class="us-testimonial__author">
                    <div class="us-testimonial__avatar">{{ $t['initial'] }}</div>
                    <div>
                        <div class="us-testimonial__name">{{ $t['name'] }}</div>
                        <div class="us-testimonial__arr">{{ $t['arr'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═════ HOW IT WORKS ═════ --}}
<section class="us-how">
    <div style="text-align:center">
        <span class="us-eyebrow">Mode d'emploi</span>
        <h2 class="us-heading">Comment ça fonctionne ?</h2>
        <p class="us-subtext">En quelques étapes simples, signalez un problème et suivez son traitement en temps réel.</p>
    </div>

    @php
    $steps = [
        ['icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','title'=>'Créez un compte','desc'=>'Inscrivez-vous gratuitement avec votre email et numéro de téléphone.'],
        ['icon'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z','title'=>'Localisez le problème','desc'=>'Utilisez la géolocalisation GPS ou indiquez l\'adresse exacte.'],
        ['icon'=>'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z','title'=>'Ajoutez des photos','desc'=>'Prenez des photos du problème pour mieux documenter le signalement.'],
        ['icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','title'=>'Suivez le traitement','desc'=>'Recevez un numéro de ticket et suivez l\'avancement des réparations.'],
    ];
    @endphp

    <div class="us-steps">
        @foreach($steps as $i => $step)
        <div class="us-step" data-num="0{{ $i+1 }}">
            <div class="us-step__icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" style="color: var(--royal)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                </svg>
            </div>
            <div class="us-step__title">{{ $step['title'] }}</div>
            <p class="us-step__desc">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ═════ TRACK ═════ --}}
<section class="us-track">
    <div class="us-track__inner">
        <span class="us-track__eyebrow">Suivi en ligne</span>
        <h2 class="us-track__title">Où en est mon signalement ?</h2>
        <p class="us-track__sub">Entrez votre numéro de ticket pour connaître l'état exact de votre signalement.</p>
        <form action="{{ route('track') }}" method="GET" class="us-track__form">
            <input type="text" name="ticket"
                   placeholder="Ex : US-2024-00001"
                   class="us-track__input"
                   value="{{ request('ticket') }}">
            <button type="submit" class="us-track__btn">Rechercher</button>
        </form>
    </div>
</section>

{{-- ═════ CTA ═════ --}}
@guest
<section class="us-cta">
    <div style="position:relative; z-index:1;">
        <h2 class="us-cta__title">Prêt à améliorer<br><em>votre commune ?</em></h2>
        <p class="us-cta__sub">Rejoignez les citoyens de Ouidah qui participent à l'amélioration de leur cadre de vie.</p>
        <a href="{{ route('register') }}" class="us-cta__btn">
            Commencer maintenant — C'est gratuit
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>
@endguest

@endsection