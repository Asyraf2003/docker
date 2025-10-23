import './bootstrap'
import Alpine from 'alpinejs'
window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
  Alpine.data('wilayahPicker', (cfg = {}) => ({
    src: cfg.src || 'https://www.emsifa.com/api-wilayah-indonesia/api',
    provs: [], kabs: [], kecs: [],
    provId: '', kabId: '', kecId: '',
    provName: cfg.provInit || '', kabName: cfg.kabInit || '', kecName: cfg.kecInit || '',
    loadingP:false, loadingK:false, loadingC:false,
    async init() {
      await this.loadProvs()
      if (this.provName) {
        const p = this.provs.find(p => p.name.toLowerCase() === this.provName.toLowerCase())
        if (p) { this.provId = p.id; await this.onProvChange(false) }
      }
      if (this.kabName) {
        const k = this.kabs.find(k => k.name.toLowerCase() === this.kabName.toLowerCase())
        if (k) { this.kabId = k.id; await this.onKabChange(false) }
      }
      if (this.kecName) {
        const c = this.kecs.find(c => c.name.toLowerCase() === this.kecName.toLowerCase())
        if (c) { this.kecId = c.id }
      }
    },
    async loadProvs(){ this.loadingP=true; this.provs = await fetch(`${this.src}/provinces.json`).then(r=>r.json()).catch(()=>[]); this.loadingP=false },
    async onProvChange(clear=true) {
      const p = this.provs.find(x => String(x.id) === String(this.provId))
      this.provName = p ? p.name : ''
      if (clear){ this.kabId=''; this.kecId=''; this.kabs=[]; this.kecs=[]; this.kabName=''; this.kecName='' }
      if (!this.provId) return
      this.loadingK = true
      this.kabs = await fetch(`${this.src}/regencies/${this.provId}.json`).then(r=>r.json()).catch(()=>[])
      this.loadingK = false
    },
    async onKabChange(clear=true) {
      const k = this.kabs.find(x => String(x.id) === String(this.kabId))
      this.kabName = k ? k.name : ''
      if (clear){ this.kecId=''; this.kecs=[]; this.kecName='' }
      if (!this.kabId) return
      this.loadingC = true
      this.kecs = await fetch(`${this.src}/districts/${this.kabId}.json`).then(r=>r.json()).catch(()=>[])
      this.loadingC = false
    },
    setKecName(){ const c = this.kecs.find(x => String(x.id) === String(this.kecId)); this.kecName = c ? c.name : '' }
  }))
})

Alpine.data('wilayahPicker', window.wilayahPicker)

Alpine.data('galleryLightbox', (items = []) => ({
  items, index: 0, isOpen: false,
  get current(){ return this.items[this.index] || {} },
  open(i=0){ this.index=i; this.isOpen=true; document.body.style.overflow='hidden'; this._preloadNeighbors() },
  close(){ this.isOpen=false; document.body.style.overflow=''; },
  next(){ this.index = (this.index + 1) % this.items.length; this._preloadNeighbors() },
  prev(){ this.index = (this.index - 1 + this.items.length) % this.items.length; this._preloadNeighbors() },
  go(i){ if(i>=0 && i<this.items.length){ this.index=i; this._preloadNeighbors() } },
  /* bonus: panah kiri/kanan */
  onKeydown(e){
    if (!this.isOpen) return
    if (e.key === 'ArrowRight') this.next()
    if (e.key === 'ArrowLeft') this.prev()
  },
  _preloadNeighbors(){
    const next = this.items[(this.index+1)%this.items.length]; if (next?.src){ const img=new Image(); img.src=next.src }
    const prev = this.items[(this.index-1+this.items.length)%this.items.length]; if (prev?.src){ const img=new Image(); img.src=prev.src }
  }
}))

Alpine.data('heroSlider', () => ({
  images: [
    '/assets/compiled/jpg/building.jpg',
    '/assets/compiled/jpg/motorcycle.jpg',
    '/assets/compiled/jpg/origami.jpg',
  ],
  current: 0, autoplayMs: 3000, timer: null,
  init() {
    this.preload()
    this.start()
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) this.stop(); else this.start()
    })
  },
  start(){ this.stop(); this.timer = setInterval(()=>this.next(), this.autoplayMs) },
  stop(){ if (this.timer) clearInterval(this.timer); this.timer = null },
  next(){ this.go(this.current + 1) },
  prev(){ this.go(this.current - 1) },
  go(i){ const n = this.images.length; this.current = ((i % n) + n) % n },
  preload(){ this.images.forEach(src => { const img = new Image(); img.src = src }) },
}))

Alpine.start()

// document.addEventListener('DOMContentLoaded', () => {
//   // ===== THEME TOGGLE =====
//   const root = document.documentElement
//   const STORAGE_KEY = 'theme'

//   const systemPrefersDark = () => window.matchMedia('(prefers-color-scheme: dark)').matches
//   const getSavedTheme = () => localStorage.getItem(STORAGE_KEY)

//   const applyTheme = (mode) => {
//     root.classList.toggle('dark', mode === 'dark')
//     localStorage.setItem(STORAGE_KEY, mode)
//   }

//   // inisialisasi
//   applyTheme(getSavedTheme() || (systemPrefersDark() ? 'dark' : 'light'))

//   const themeButtons = ['theme-toggle', 'theme-toggle-mobile']
//     .map(id => document.getElementById(id))
//     .filter(Boolean)

//   themeButtons.forEach(btn => btn.addEventListener('click', () => {
//     const next = root.classList.contains('dark') ? 'light' : 'dark'
//     applyTheme(next)
//   }))

//   // ===== MOBILE NAV =====
//   const navToggle = document.getElementById('nav-toggle')
//   const mobileMenu = document.getElementById('mobile-menu')

//   if (navToggle && mobileMenu) {
//     navToggle.setAttribute('aria-controls', 'mobile-menu')
//     navToggle.setAttribute('aria-expanded', 'false')

//     navToggle.addEventListener('click', () => {
//       const isHidden = mobileMenu.classList.contains('hidden')
//       mobileMenu.classList.toggle('hidden')
//       navToggle.setAttribute('aria-expanded', String(isHidden))
//     })

//     // auto close setelah klik link
//     mobileMenu.querySelectorAll('a').forEach(a => {
//       a.addEventListener('click', () => {
//         mobileMenu.classList.add('hidden')
//         navToggle.setAttribute('aria-expanded', 'false')
//       })
//     })
//   }
// })
document.addEventListener('DOMContentLoaded', () => {
  const root = document.documentElement
  const STORAGE_KEY='theme'
  const systemPrefersDark = () => window.matchMedia('(prefers-color-scheme: dark)').matches
  const getSavedTheme = () => localStorage.getItem(STORAGE_KEY)
  const applyTheme = (mode) => { root.classList.toggle('dark', mode==='dark'); localStorage.setItem(STORAGE_KEY, mode) }
  applyTheme(getSavedTheme() || (systemPrefersDark() ? 'dark' : 'light'))
  ;['theme-toggle','theme-toggle-mobile'].map(id=>document.getElementById(id)).filter(Boolean)
    .forEach(btn=>btn.addEventListener('click', ()=>applyTheme(root.classList.contains('dark')?'light':'dark')))
  const navToggle=document.getElementById('nav-toggle'), mobileMenu=document.getElementById('mobile-menu')
  if (navToggle && mobileMenu){
    navToggle.setAttribute('aria-controls','mobile-menu'); navToggle.setAttribute('aria-expanded','false')
    navToggle.addEventListener('click', ()=>{ const closed=mobileMenu.classList.toggle('hidden'); navToggle.setAttribute('aria-expanded', String(!closed)) })
    mobileMenu.querySelectorAll('a').forEach(a=>a.addEventListener('click', ()=>{ mobileMenu.classList.add('hidden'); navToggle.setAttribute('aria-expanded','false') }))
  }
})