export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    //{ path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '/product/category', component: require('./components/product/Category.vue').default },
    
    // Generated routes comes below //
	
	
	{ path: '/schools', component: require('./components/honestee/vuecodegen/School.vue').default },
	
	{ path: '/sections', component: require('./components/honestee/vuecodegen/Section.vue').default },
	
	{ path: '/classrooms', component: require('./components/honestee/vuecodegen/Classroom.vue').default },
	
	{ path: '/subjects', component: require('./components/honestee/vuecodegen/Subject.vue').default },
	
	{ path: '/departments', component: require('./components/honestee/vuecodegen/Department.vue').default },
	
	{ path: '/assessments', component: require('./components/honestee/vuecodegen/Assessment.vue').default },
	
	{ path: '/parts', component: require('./components/honestee/vuecodegen/Part.vue').default },
	
	{ path: '/codes', component: require('./components/honestee/vuecodegen/Code.vue').default },
	
	{ path: '/roles', component: require('./components/honestee/vuecodegen/Role.vue').default },
	
	{ path: '/permissions', component: require('./components/honestee/vuecodegen/Permission.vue').default },
	
	{ path: '/users', component: require('./components/honestee/vuecodegen/User.vue').default },
	
	{ path: '/options', component: require('./components/honestee/vuecodegen/Option.vue').default },

	{ path: '/app-permissions', component: require('./components/honestee/vuecodegen/AppPermission.vue').default },
	
	{ path: '/under-construction', component: require('./components/honestee/vuecodegen/UnderConstruction.vue').default },
	{ path: '/student-result', component: require('./components/honestee/vuecodegen/StudentResult.vue').default },

	
	{ path: '/classroom-users', component: require('./components/honestee/vuecodegen/UserClassroom.vue').default },
	{ path: '/user-classrooms', component: require('./components/honestee/vuecodegen/ClassroomUser.vue').default },
	{ path: '/classroom-subjects', component: require('./components/honestee/vuecodegen/SubjectClassroom.vue').default },
	{ path: '/subject-classrooms', component: require('./components/honestee/vuecodegen/ClassroomSubject.vue').default },
	
	{ path: '/resultinfos', component: require('./components/honestee/vuecodegen/Resultinfo.vue').default },
	{ path: '*', component: require('./components/NotFound.vue').default },
];

