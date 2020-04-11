-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2019 at 09:12 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kb_storage`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `resolution` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `approved` int(11) DEFAULT '0',
  `auth_id1` int(11) DEFAULT NULL,
  `auth_id2` int(11) DEFAULT NULL,
  `creation_time` datetime DEFAULT NULL,
  `lastemail_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `description`, `resolution`, `user_id`, `approved`, `auth_id1`, `auth_id2`, `creation_time`, `lastemail_time`) VALUES
(2, 'How do I avoid typing â€œgitâ€ at the begining of every Git command?', 'I\'m wondering if there\'s a way to avoid having to type the word git at the beginning of every Git command.\r\n\r\nIt would be nice if there was a way to use the git command only once in the beginning after opening a command prompt to get into \"Git mode\".\r\n\r\nFor example:\r\n\r\ngit>\r\nAfter which every command we type is by default interpreted as a Git command.\r\n\r\nIn a way similar to how we use the MySQL shell to write database commands:\r\n\r\nmysql>\r\nThis will save me from typing \'git\' hundreds of time every day.', 'You might want to try gitsh. From their readme:\r\n\r\nThe gitsh program is an interactive shell for git. From within gitsh you can issue any git command, even using your local aliases and configuration.\r\n\r\nGit commands tend to come in groups. Avoid typing git over and over and over by running them in a dedicated git shell:\r\nsh$ gitsh\r\ngitsh% status\r\ngitsh% add .\r\ngitsh% commit -m \"Ship it!\"\r\ngitsh% push\r\ngitsh% ctrl-d\r\nsh$\r\nOr have a look at the other projects linked there:\r\n\r\ngit-sh - A customised bash shell with a Git prompt, aliases, and completion.\r\ngitsh - A simple Git shell written in Perl.\r\nrepl - Wraps any program with subcommands in a REPL.', 1, 1, 0, 0, '2019-06-25 11:40:22', 1561443022),
(3, 'Are there downsides to using std::string as a buffer?', 'I have recently seen a colleague of mine using std::string as a buffer:\r\n\r\nstd::string receive_data(const Receiver& receiver) {\r\n  std::string buff;\r\n  int size = receiver.size();\r\n  if (size > 0) {\r\n    buff.resize(size);\r\n    const char* dst_ptr = buff.data();\r\n    const char* src_ptr = receiver.data();\r\n    memcpy((char*) dst_ptr, src_ptr, size);\r\n  }\r\n  return buff;\r\n}\r\nI guess this guy wants to take advantage of auto destruction of the returned string so he needs not worry about freeing of the allocated buffer.\r\n\r\nThis looks a bit strange to me since according to cplusplus.com the data() method returns a const char* pointing to a buffer internally managed by the string:\r\n\r\nconst char* data() const noexcept;\r\nMemcpy-ing to a const char pointer? AFAIK this does no harm as long as we know what we do, but have I missed something? Is this dangerous?', 'Don\'t use std::string as a buffer.\r\nIt is bad practice to use std::string as a buffer, for several reasons (listed in no particular order):\r\n\r\nstd::string was not intended for use as a buffer; you would need to double-check the description of the class to make sure there are no \"gotchas\" which would prevent certain usage patterns (or make them trigger undefined behavior).\r\nSpecifically: Before C++17, you can\'t even write through the pointer you get with data() - it\'s const Tchar *; so your code would cause undefined behavior. (But &(str[0]), &(str.front()), or &(*(str.begin())) would work.)\r\nUsing std::string\'s for buffers is confusing to readers of the implementation, who assume you would be using std::string for, well, strings.\r\nWorse yet, it\'s confusing for whoever might use this function - they too may think what you\'re returning is a string, i.e. valid human-readable text.\r\nstd::unique_ptr would be fine for your case, or even std::vector. In C++17, you can use std::byte for the element type, too. A more sophisticated option is a class with an SSO-like feature, e.g. Boost\'s small_vector (thank you, @gast128, for mentioning it).\r\n(Minor point:) libstdc++ had to change its ABI for std::string to conform to the C++11 standard, which in some cases (which by now are rather unlikely), you might run into some linkage or runtime issues that you wouldn\'t with a different type for your buffer.\r\n', 1, 1, 0, 0, '2019-06-25 11:42:03', 1561443123),
(4, 'How to use memset in c++?', 'I am from Python background and recently learning C++. I was learning a C/C++ function called memset and following the online example from website https://www.geeksforgeeks.org/memset-in-cpp/ where I got some compilation errors:\r\n\r\n/**\r\n * @author      : Bhishan Poudel\r\n * @file        : a02_memset_geeks.cpp\r\n * @created     : Wednesday Jun 05, 2019 11:07:03 EDT\r\n * \r\n * Ref: \r\n */\r\n\r\n#include <iostream>\r\n#include <vector>\r\n#include <cstring>\r\n\r\nusing namespace std;\r\n\r\nint main(int argc, char *argv[]){\r\n    char str[] = \"geeksforgeeks\";\r\n\r\n    //memset(str, \"t\", sizeof(str));\r\n    memset(str, \'t\', sizeof(str));\r\n\r\n    cout << str << endl;\r\n\r\n    return 0;\r\n}\r\nError when using single quotes \'t\'\r\nThis prints extra characters.\r\n\r\ntttttttttttttt!R@`\r\nError when using \"t\" with double quotes\r\n\r\n$ g++ -std=c++11 a02_memset_geeks.cpp \r\na02_memset_geeks.cpp:17:5: error: no matching function for call to \'memset\'\r\n    memset(str, \"t\", sizeof(str));\r\n    ^~~~~~\r\n/usr/include/string.h:74:7: note: candidate function not viable: no known\r\n      conversion from \'const char [2]\' to \'int\' for 2nd argument\r\nvoid    *memset(void *, int, size_t);\r\n         ^\r\n1 error generated.\r\nHow to use the memset in C++ ?', 'This declaration\r\n\r\nchar str[] = \"geeksforgeeks\";\r\ndeclares a character array that contains a string that is a sequence of characters including the terminating zero symbol \'\\0\'.\r\n\r\nYou can imagine the declaration the following equivalent way\r\n\r\nchar str[] = \r\n{ \r\n    \'g\', \'e\', \'e\', \'k\', \'s\', \'f\', \'o\', \'r\', \'g\', \'e\', \'e\', \'k\', \'s\', \'\\0\'\r\n};\r\nThis call of the function memset\r\n\r\nmemset(str, \'t\', sizeof(str));\r\noverrides all characters of the array including the terminating zero.\r\n\r\nSo the next statement\r\n\r\ncout << str << endl;\r\nresults in undefined behaviour because it outpuuts characters until the terminating zero is encountered.\r\n\r\nYou could write instead\r\n\r\n#include <iostream>\r\n#include <cstring>\r\n\r\nint main()\r\n{\r\n    char str[] = \"geeksforgeeks\";\r\n\r\n    std::memset( str, \'t\', sizeof( str ) - 1 );\r\n\r\n    std::cout << str << \'\\n\';\r\n}', 1, 1, 0, 0, '2019-06-25 11:43:25', 1561443205),
(5, 'How should I use the new static option for @ViewChild in Angular 8?', 'How should I configure the new Angular 8 view child?\r\n\r\n@ViewChild(\'searchText\', {read: ElementRef, static: false})\r\npublic searchTextInput: ElementRef;\r\nvs\r\n\r\n@ViewChild(\'searchText\', {read: ElementRef, static: true})\r\npublic searchTextInput: ElementRef;\r\nWhich is better? When should I use static:true vs static:false?', 'In most cases you will want to use {static: false}. Setting it like this will ensure query matches that are dependent on binding resolution (like structural directives *ngIf, etc...) will be found.\r\n\r\nExample of when to use static: false:\r\n\r\n@Component({\r\n  template: `\r\n    <div *ngIf=\"showMe\" #viewMe>Am I here?</div>\r\n    <button (click)=\"showMe = !showMe\"></button>\r\n  ` \r\n})\r\nexport class ExampleComponent {\r\n  @ViewChild(\'viewMe\', { static: false })\r\n  viewMe?: ElementRef<HTMLElement>; \r\n\r\n  showMe = false;\r\n}\r\nThe static: false is going to be the default fallback behaviour in Angular 9. Read more here and here\r\n\r\nThe { static: true } option was introduced to support creating embedded views on the fly. When you are creating a view dynamically and want to acces the TemplateRef, you won\'t be able to do so in ngAfterViewInit as it will cause a ExpressionHasChangedAfterChecked error. Setting the static flag to true will create your view in ngOnInit.', 1, 1, 0, 0, '2019-06-25 11:44:17', 1561443257),
(6, 'create-react-app â€œFailed to compileâ€ on start up', 'I am getting the following error when using npm start to open create-react-app. I\'m new to React and I have had no problems the past few days doing the command line to make a new app.\r\n\r\nI have tried npx start, npm start and installed npm again for the updated version.\r\n\r\nFailed to compile\r\n./src/index.css (./node_modules/css-loader/dist/cjs.js??ref--6-oneOf-3-1!./node_modules/postcss-loader/src??postcss!./src/index.css)\r\nBrowserslistError: Unknown browser query `android all`. Maybe you are using old Browserslist or made typo in query.\r\n    at Array.reduce (<anonymous>)\r\n    at Array.some (<anonymous>)\r\n    at Array.filter (<anonymous>)', 'It is a new bug in BrowserList.\r\n\r\nThere are new reports on this both in create-react-app: https://github.com/facebook/create-react-app/issues/7239\r\n\r\nand in browserlist: https://github.com/browserslist/browserslist/issues/382#issuecomment-502991170\r\n\r\nAs suggested by John Forbes below the workaround given on the github issue is to change the browserslist entry in package.json to\r\n\r\n\"browserslist\": []\r\nThis will build and run the project.', 1, 0, 9094215, 9174692, '2019-06-25 11:44:45', 1561443285),
(7, 'How to solve â€œTypeError: process.getuid is not a functionâ€', 'I am running react.js with laravel and watching changes with yarn run watch which has worked fine until I began to come across this error with webpack any time I used yarn or npm after I made some windows 10 updates (I really don\'t know if that could be a reason) - I would love any help.\r\n\r\nif (!e && fileOwnerId === process.getuid()) utimesSync(openCollectivePath, now, now)\r\nThe error:\r\n\r\nTypeError: process.getuid is not a function at C:\\project_path\\node_modules\\webpack-cli\\bin\\cli.js:352:43 at FSReqCallback.oncomplete (fs.js:153:23)\r\n', 'I was just having this issue as well. I\'m not sure what caused it, but deleting my node_modules folder and re-running \"npm install\" fixed it for me.\r\n\r\n', 1, 1, 0, 0, '2019-06-25 11:46:17', 1561443377),
(8, 'Why is C++ initial allocation so much larger than C\'s?', 'When using the same code, simply changing the compiler (from a C compiler to a C++ compiler) will change how much memory is allocated. I\'m not quite sure why this is and would like to understand it more. So far the best response I\'ve gotten is \"probably the IO streams\", which isn\'t very descriptive and makes me wonder about the \"you don\'t pay for what you don\'t use\" aspect of C++.\r\n\r\nI\'m using the clang and gcc compilers, versions 7.0.1-8 and 8.3.0-6 respectively. My system is running on Debian 10 (Buster), latest. The benchmarks are done via Valgrind Massif.\r\n\r\n#include <stdio.h>\r\n\r\nint main() {\r\n    printf(\"Hello, world!\\n\");\r\n    return 0;\r\n}\r\nThe code used does not change, but whether I compile as C or as C++ changes the results of the Valgrind benchmark. The values remain consistent across compilers, however. The runtime allocations (peak) for the program go as follows:\r\n\r\nGCC (C): 1,032 bytes (1KB)\r\nG++ (C++): 73,744 bytes, (~74KB)\r\nClang (C): 1,032 bytes (1KB)\r\nClang++ (C++): 73,744 bytes (~74KB)\r\nFor compiling, I use the following commands:\r\n\r\nclang -O3 -o c-clang ./main.c\r\ngcc -O3 -o c-gcc ./main.c\r\nclang++ -O3 -o cpp-clang ./main.cpp\r\ng++ -O3 -o cpp-gcc ./main.cpp\r\nFor Valgrind, I run valgrind --tool=massif --massif-out-file=m_compiler_lang ./compiler-lang on each compiler and language, then ms_print for displaying the peaks.\r\n\r\nAm I doing something wrong here?', 'The heap usage comes from the C++ standard library. It allocates memory for internal library use on startup. If you don\'t link against it, there should be zero difference between the C and C++ version. With GCC and Clang, you can compile the file with:\r\n\r\ng++ -Wl,--as-needed main.cpp\r\nThis will instruct the linker to not link against unused libraries. In your example code, the C++ library is not used, so it should not link against the C++ standard library.\r\n\r\nYou can also test this with the C file. If you compile with:\r\n\r\ngcc main.c -lstdc++\r\nThe heap usage will reappear, even though you\'ve built a C program.', 1, 1, 0, 0, '2019-06-25 11:47:05', 1561443425),
(9, 'Most elegant way to write a one shot IF', 'Since C++ 17 one can write an If-block that will get executed exactly once like this:\r\n\r\n#include <iostream>\r\nint main() {\r\n    for (unsigned i = 0; i < 10; ++i) {\r\n\r\n        if (static bool do_once = true; do_once) { // enter only once\r\n            std::cout << \"hello one-shot\" << std::endl;\r\n            // possibly much more code\r\n            do_once = false;\r\n        }\r\n\r\n    }\r\n}\r\nI know I might be overthinking this, there are other ways to solve this, but still - is it possible to write this somehow like this, so there is no need of the do_once = false at the end?\r\n\r\nif (DO_ONCE) {\r\n    // do stuff\r\n}\r\nI\'m thinking a helper function do_once() containing the static bool do_once, but what if i wanted to use that same function in different places? Might this be the time and place for a #define? I hope not.', 'Use std::exchange:\r\n\r\nif (static bool do_once = true; std::exchange(do_once, false))\r\nYou can make it shorter reversing the truth value:\r\n\r\nif (static bool do_once; !std::exchange(do_once, false))\r\nBut if you are using this a lot, don\'t be fancy and create a wrapper instead:\r\n\r\nstruct Once {\r\n    bool b = true;\r\n    explicit operator bool() { return std::exchange(b, false); }\r\n};\r\nAnd use it like:\r\n\r\nif (static Once once; once)\r\nIf you are a Python fan, you can use their underscore idiom for throw-away variables:\r\n\r\nif (static Once _; _)', 1, 0, 3443249, 1199910, '2019-06-25 11:52:16', 1561443736),
(10, 'How to prevent text in a table cell from wrapping', 'Does anyone know how I can prevent the text in a table cell from wrapping? This is for the header of a table, and the heading is a lot longer than the data under it, but I need it to display on only one line. It is okay if the column is very wide.', 'Have a look at the white-space property, used like this:\r\n\r\nth {\r\n    white-space: nowrap;\r\n}\r\nThis will force the contents of <th> to display on one line.', 1, 0, 2758812, 9368572, '2019-06-25 11:59:37', 1561444177);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);
ALTER TABLE `posts` ADD FULLTEXT KEY `title` (`title`,`description`,`resolution`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
