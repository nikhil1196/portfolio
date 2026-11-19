<?php
// School ERP — injected modules: subjects, staff, timetable, materials, assignments, submissions, exams
return [
    'base_tables' => ['SchoolClass' => 'school_classes', 'Student' => 'students', 'Teacher' => 'teachers'],
    'nav' => [
        ['Subjects', 'subjects.index', 'book'],
        ['Staff', 'staff.index', 'briefcase'],
        ['Timetable', 'timetable.index', 'calendar'],
        ['Materials', 'materials.index', 'clipboard'],
        ['Assignments', 'assignments.index', 'clipboard'],
        ['Submissions', 'submissions.index', 'check'],
        ['Exams', 'exams.index', 'star'],
    ],
    'modules' => [
        'subjects' => [
            'model' => 'Subject', 'title' => 'Subject', 'icon' => 'book',
            'columns' => [['name','string'],['code','stringNullable'],['class_id','fkreq:SchoolClass:class_id'],['teacher_id','fk:Teacher'],['status','statusActive']],
            'fillable' => ['name','code','class_id','teacher_id','status'],
            'validation' => ['name'=>'required|string|max:255','code'=>'nullable|string','class_id'=>'required|exists:school_classes,id','teacher_id'=>'nullable|exists:teachers,id','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Subject Name','text',null,true], ['code','Code','text'],
                ['class_id','Class','select','@SchoolClass',true], ['teacher_id','Teacher','select','@Teacher'],
                ['status','Status','select',['Active','Inactive']],
            ],
            'with' => ['schoolClass','teacher'],
            'rels' => ['schoolClass' => 'belongsTo:SchoolClass:class_id', 'teacher' => 'belongsTo:Teacher'],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Code' => '{{ $r->code }}',
                'Class' => '{{ $r->schoolClass->name ?? "—" }}', 'Teacher' => '{{ $r->teacher->name ?? "—" }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'staff' => [
            'model' => 'Staff', 'title' => 'Staff', 'icon' => 'briefcase', 'table' => 'staff',
            'columns' => [['name','string'],['role','stringNullable'],['dept','stringNullable'],['phone','stringNullable'],['email','stringNullable'],['joined','dateNullable'],['status','statusActive']],
            'fillable' => ['name','role','dept','phone','email','joined','status'],
            'validation' => ['name'=>'required|string|max:255','role'=>'nullable|string','dept'=>'nullable|string','phone'=>'nullable|string','email'=>'nullable|email','joined'=>'nullable|date','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['name','Staff Name','text',null,true], ['role','Role','select',['Accountant','Librarian','Clerk','Peon','Driver','Security','Other']],
                ['dept','Department','text'], ['phone','Phone','tel'], ['email','Email','email'],
                ['joined','Joining Date','date'], ['status','Status','select',['Active','Inactive']],
            ],
            'cols' => [
                'Name' => '<strong>{{ $r->name }}</strong>', 'Role' => '{{ $r->role }}',
                'Dept' => '{{ $r->dept }}', 'Phone' => '{{ $r->phone }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'timetable' => [
            'model' => 'Timetable', 'title' => 'Timetable Entry', 'icon' => 'calendar',
            'columns' => [['class_id','fkreq:SchoolClass:class_id'],['day','string'],['period','integer'],['subject_id','fkreq:Subject'],['teacher_id','fkreq:Teacher'],['start_time','time'],['end_time','time']],
            'fillable' => ['class_id','day','period','subject_id','teacher_id','start_time','end_time'],
            'validation' => ['class_id'=>'required|exists:school_classes,id','day'=>'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday','period'=>'required|integer|min:1|max:10','subject_id'=>'required|exists:subjects,id','teacher_id'=>'required|exists:teachers,id','start_time'=>'required','end_time'=>'required'],
            'fields' => [
                ['class_id','Class','select','@SchoolClass',true], ['day','Day','select',['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],true],
                ['period','Period #','number',null,true], ['subject_id','Subject','select','@Subject',true],
                ['teacher_id','Teacher','select','@Teacher',true], ['start_time','Start','time',null,true], ['end_time','End','time',null,true],
            ],
            'with' => ['schoolClass','subject','teacher'],
            'rels' => ['schoolClass' => 'belongsTo:SchoolClass:class_id', 'subject' => 'belongsTo:Subject', 'teacher' => 'belongsTo:Teacher'],
            'cols' => [
                'Class' => '<strong>{{ $r->schoolClass->name }}</strong>', 'Day' => '{{ $r->day }}',
                'Period' => 'P{{ $r->period }}', 'Subject' => '{{ $r->subject->name }}',
                'Teacher' => '{{ $r->teacher->name }}', 'Time' => '{{ substr($r->start_time,0,5) }}–{{ substr($r->end_time,0,5) }}',
            ],
        ],
        'materials' => [
            'model' => 'Material', 'title' => 'Study Material', 'icon' => 'clipboard',
            'columns' => [['title','string'],['subject_id','fkreq:Subject'],['class_id','fkreq:SchoolClass:class_id'],['type','default:Notes'],['url','stringNullable'],['status','statusActive']],
            'fillable' => ['title','subject_id','class_id','type','url','status'],
            'validation' => ['title'=>'required|string|max:255','subject_id'=>'required|exists:subjects,id','class_id'=>'required|exists:school_classes,id','type'=>'required|in:Notes,PDF,Link,Video','url'=>'nullable|string','status'=>'required|in:Active,Inactive'],
            'fields' => [
                ['title','Title','text',null,true], ['subject_id','Subject','select','@Subject',true],
                ['class_id','Class','select','@SchoolClass',true], ['type','Type','select',['Notes','PDF','Link','Video'],true],
                ['url','Link / File URL','text'], ['status','Status','select',['Active','Inactive']],
            ],
            'with' => ['subject','schoolClass'],
            'rels' => ['subject' => 'belongsTo:Subject', 'schoolClass' => 'belongsTo:SchoolClass:class_id'],
            'cols' => [
                'Title' => '<strong>{{ $r->title }}</strong>', 'Subject' => '{{ $r->subject->name }}',
                'Class' => '{{ $r->schoolClass->name }}', 'Type' => '<span class="badge">{{ $r->type }}</span>',
                'Link' => '{{ $r->url ? "View" : "—" }}',
            ],
        ],
        'assignments' => [
            'model' => 'Assignment', 'title' => 'Assignment', 'icon' => 'clipboard',
            'columns' => [['title','string'],['subject_id','fkreq:Subject'],['class_id','fkreq:SchoolClass:class_id'],['teacher_id','fkreq:Teacher'],['due_date','date'],['description','textNullable'],['status','default:Open']],
            'fillable' => ['title','subject_id','class_id','teacher_id','due_date','description','status'],
            'validation' => ['title'=>'required|string|max:255','subject_id'=>'required|exists:subjects,id','class_id'=>'required|exists:school_classes,id','teacher_id'=>'required|exists:teachers,id','due_date'=>'required|date','description'=>'nullable|string','status'=>'required|in:Open,Closed'],
            'fields' => [
                ['title','Title','text',null,true], ['subject_id','Subject','select','@Subject',true],
                ['class_id','Class','select','@SchoolClass',true], ['teacher_id','Teacher','select','@Teacher',true],
                ['due_date','Due Date','date',null,true], ['description','Description','textarea'],
                ['status','Status','select',['Open','Closed']],
            ],
            'with' => ['subject','schoolClass','teacher'],
            'rels' => ['subject' => 'belongsTo:Subject', 'schoolClass' => 'belongsTo:SchoolClass:class_id', 'teacher' => 'belongsTo:Teacher'],
            'cols' => [
                'Title' => '<strong>{{ $r->title }}</strong>', 'Subject' => '{{ $r->subject->name }}',
                'Class' => '{{ $r->schoolClass->name }}', 'Due' => '{{ $r->due_date }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'submissions' => [
            'model' => 'Submission', 'title' => 'Submission', 'icon' => 'check',
            'columns' => [['assignment_id','fkreq:Assignment'],['student_id','fkreq:Student'],['submitted_at','datetime'],['notes','textNullable'],['marks','intNullable'],['status','default:Submitted']],
            'fillable' => ['assignment_id','student_id','submitted_at','notes','marks','status'],
            'validation' => ['assignment_id'=>'required|exists:assignments,id','student_id'=>'required|exists:students,id','submitted_at'=>'required|date','notes'=>'nullable|string','marks'=>'nullable|integer|min:0','status'=>'required|in:Submitted,Late,Graded'],
            'fields' => [
                ['assignment_id','Assignment','select','@Assignment:title',true], ['student_id','Student','select','@Student',true],
                ['submitted_at','Submitted At','datetime-local',null,true], ['marks','Marks','number'],
                ['notes','Notes','textarea'], ['status','Status','select',['Submitted','Late','Graded']],
            ],
            'with' => ['assignment','student'],
            'rels' => ['assignment' => 'belongsTo:Assignment', 'student' => 'belongsTo:Student'],
            'cols' => [
                'Assignment' => '<strong>{{ $r->assignment->title }}</strong>', 'Student' => '{{ $r->student->name }}',
                'Submitted' => '{{ $r->submitted_at }}', 'Marks' => '{{ $r->marks ?? "—" }}',
                'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
        'exams' => [
            'model' => 'Exam', 'title' => 'Exam', 'icon' => 'star',
            'columns' => [['name','string'],['class_id','fkreq:SchoolClass:class_id'],['subject_id','fkreq:Subject'],['exam_date','date'],['max_marks','integer'],['status','default:Scheduled']],
            'fillable' => ['name','class_id','subject_id','exam_date','max_marks','status'],
            'validation' => ['name'=>'required|string|max:255','class_id'=>'required|exists:school_classes,id','subject_id'=>'required|exists:subjects,id','exam_date'=>'required|date','max_marks'=>'required|integer|min:1','status'=>'required|in:Scheduled,Ongoing,Completed'],
            'fields' => [
                ['name','Exam Name','text',null,true], ['class_id','Class','select','@SchoolClass',true],
                ['subject_id','Subject','select','@Subject',true], ['exam_date','Date','date',null,true],
                ['max_marks','Max Marks','number',null,true], ['status','Status','select',['Scheduled','Ongoing','Completed']],
            ],
            'with' => ['schoolClass','subject'],
            'rels' => ['schoolClass' => 'belongsTo:SchoolClass:class_id', 'subject' => 'belongsTo:Subject'],
            'cols' => [
                'Exam' => '<strong>{{ $r->name }}</strong>', 'Class' => '{{ $r->schoolClass->name }}',
                'Subject' => '{{ $r->subject->name }}', 'Date' => '{{ $r->exam_date }}',
                'Max' => '{{ $r->max_marks }}', 'Status' => '<span class="badge">{{ $r->status }}</span>',
            ],
        ],
    ],
    'seed' => [
        'Subject' => [
            ['name'=>'Mathematics','code'=>'MATH','class_id'=>1,'teacher_id'=>1,'status'=>'Active'],
            ['name'=>'Science','code'=>'SCI','class_id'=>1,'teacher_id'=>2,'status'=>'Active'],
            ['name'=>'English','code'=>'ENG','class_id'=>2,'teacher_id'=>3,'status'=>'Active'],
        ],
        'Staff' => [
            ['name'=>'Ramesh Yadav','role'=>'Accountant','dept'=>'Accounts','phone'=>'9811111111','email'=>'ramesh@school.demo','joined'=>'2020-06-01','status'=>'Active'],
            ['name'=>'Sunita Verma','role'=>'Librarian','dept'=>'Library','phone'=>'9811111112','email'=>'sunita@school.demo','joined'=>'2021-04-15','status'=>'Active'],
        ],
        'Timetable' => [
            ['class_id'=>1,'day'=>'Monday','period'=>1,'subject_id'=>1,'teacher_id'=>1,'start_time'=>'09:00','end_time'=>'09:45'],
            ['class_id'=>1,'day'=>'Monday','period'=>2,'subject_id'=>2,'teacher_id'=>2,'start_time'=>'09:45','end_time'=>'10:30'],
            ['class_id'=>2,'day'=>'Tuesday','period'=>1,'subject_id'=>3,'teacher_id'=>3,'start_time'=>'09:00','end_time'=>'09:45'],
        ],
        'Material' => [
            ['title'=>'Algebra Notes Ch.1','subject_id'=>1,'class_id'=>1,'type'=>'PDF','url'=>'materials/algebra-ch1.pdf','status'=>'Active'],
            ['title'=>'Photosynthesis Video','subject_id'=>2,'class_id'=>1,'type'=>'Video','url'=>'https://demo.local/photo-video','status'=>'Active'],
        ],
        'Assignment' => [
            ['title'=>'Quadratic Equations HW','subject_id'=>1,'class_id'=>1,'teacher_id'=>1,'due_date'=>'2026-12-10','description'=>'Solve exercises 1–10','status'=>'Open'],
            ['title'=>'Essay: My City','subject_id'=>3,'class_id'=>2,'teacher_id'=>3,'due_date'=>'2026-12-15','description'=>'500 words','status'=>'Open'],
        ],
        'Submission' => [
            ['assignment_id'=>1,'student_id'=>1,'submitted_at'=>'2026-11-20 10:00','notes'=>'All done','marks'=>9,'status'=>'Graded'],
        ],
        'Exam' => [
            ['name'=>'Midterm','class_id'=>1,'subject_id'=>1,'exam_date'=>'2026-12-20','max_marks'=>100,'status'=>'Scheduled'],
            ['name'=>'Midterm','class_id'=>1,'subject_id'=>2,'exam_date'=>'2026-12-21','max_marks'=>100,'status'=>'Scheduled'],
        ],
    ],
];
