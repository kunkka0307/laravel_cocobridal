function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'index', component: page('index.vue') },
  { path: '/search', name: 'search', component: page('search.vue') },
  { path: '/party/:id', name: 'party', component: page('party.vue') },
  { path: '/favorite', name: 'favorite', component: page('favorite.vue') },
  { path: '/profile', name: 'profile', component: page('auth/profileRegister.vue') },
  { path: '/profile/main', name: 'profile.main', component: page('auth/profileMainEdit.vue') },
  { path: '/profile/comment', name: 'profile.comment', component: page('auth/profileCommentEdit.vue') },
  { path: '/profile/data', name: 'profile.data', component: page('auth/profileDataEdit.vue') },
  { path: '/profile/credit', name: 'profile.credit', component: page('auth/profileCreditEdit.vue') },
  { path: '/book', name: 'book', component: page('book.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/profileregister/:id', name: 'profileregister', component: page('auth/profileRegister.vue') },
  { path: '/verifysended', name: 'verifysended', component: page('auth/verifysended.vue') },
  { path: '/reserve/:id', name: 'reserve', component: page('reserve.vue') },
  { path: '/mypage', name: 'mypage', component: page('mypage.vue') },
  { path: '/savedsearch', name: 'savedsearch', component: page('savedSearch.vue') },
  { path: '/searchresult', name: 'searchresult', component: page('searchResult.vue') },

  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  {
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ]
  },

  { path: '*', component: page('errors/404.vue') }
]
