-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2015 at 05:04 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `journal`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voliss_id` int(11) NOT NULL,
  `paper_id` varchar(50) NOT NULL,
  `reviewer_id` int(11) NOT NULL DEFAULT '0',
  `article_title` varchar(255) NOT NULL,
  `research_area` varchar(255) NOT NULL,
  `a_type_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `a_org` varchar(100) NOT NULL,
  `a_email` varchar(100) NOT NULL,
  `a_phone` varchar(10) NOT NULL,
  `addr_1` varchar(255) NOT NULL,
  `addr_2` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `article_file` varchar(255) NOT NULL,
  `article_review` text NOT NULL,
  `paid_online` tinyint(1) NOT NULL DEFAULT '0',
  `payment_file` varchar(255) NOT NULL,
  `copyright_file` varchar(255) NOT NULL,
  `hardcopy` tinyint(1) NOT NULL DEFAULT '0',
  `formatter_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '''1''=>''Recieved'', ''3''=>''Reviewed'', ''5''=>''Accepted'', ''7''=>''Payment Done'',''10''=>''Payment Accepted'' ,''13''=>''Sent to Formatter'', ''15''=>Format Done',
  `file_path` varchar(255) NOT NULL,
  `created_dt` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_type`
--

CREATE TABLE IF NOT EXISTS `article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `article_type`
--

INSERT INTO `article_type` (`id`, `name`, `status`, `is_deleted`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(1, 'Research Article', 1, 0, 1440135686, 1, 1440135686, 1),
(2, 'Reveiw Article', 1, 0, 1440135697, 1, 1440135697, 1),
(3, 'Short Communication', 1, 0, 1440135710, 1, 1440135710, 1),
(4, 'Case Study', 1, 0, 1440135720, 1, 1440135720, 1),
(5, 'Other', 1, 0, 1440135727, 1, 1440135727, 1);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `status`, `is_deleted`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(1, 'Aeronautical Engineering', 1, 0, 1440135826, 1, 1440335292, 1),
(2, 'Aerospace Engineer', 1, 0, 1440135837, 1, 1440135837, 1),
(3, 'Agricultural Engineer', 1, 0, 1440135860, 1, 1440135860, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE IF NOT EXISTS `cms` (
  `id` varchar(50) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '''1:Yes'',''2:No''',
  `is_deleted` smallint(6) NOT NULL DEFAULT '0' COMMENT '''1:Yes'',''2:No''',
  `created_by` int(11) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `page_title`, `page_name`, `content`, `slug`, `meta_key`, `meta_description`, `status`, `is_deleted`, `created_by`, `created_dt`, `updated_by`, `updated_dt`) VALUES
('aboutus', 'About Us', '', '<p>\r\n<script>// <![CDATA[\r\n#prit_DIV_1 {\r\n    color: rgb(61, 61, 61);\r\n    float: left;\r\n    height: 178px;\r\n    width: 665.40625px;\r\n    perspective-origin: 343.703125px 100px;\r\n    transform-origin: 343.703125px 100px;\r\n    border: 1px solid rgb(225, 225, 225);\r\n    border-radius: 4px 4px 4px 4px;\r\n    font: normal normal normal normal 12px/normal OpenSansRegular;\r\n    margin: 15px 0px;\r\n    outline: rgb(61, 61, 61) none 0px;\r\n    padding: 10px;\r\n}/*#prit_DIV_1*/\r\n\r\n#prit_P_2, #prit_P_4 {\r\n    color: rgb(61, 61, 61);\r\n    height: 36px;\r\n    width: 665.40625px;\r\n    perspective-origin: 332.703125px 18px;\r\n    transform-origin: 332.703125px 18px;\r\n    border: 0px none rgb(61, 61, 61);\r\n    font: normal normal normal normal 12px/18px OpenSansRegular;\r\n    margin: 0px;\r\n    outline: rgb(61, 61, 61) none 0px;\r\n}/*#prit_P_2, #prit_P_4*/\r\n\r\n#prit_STRONG_3, #prit_STRONG_5, #prit_STRONG_7 {\r\n    color: rgb(61, 61, 61);\r\n    border: 0px none rgb(61, 61, 61);\r\n    font: normal normal bold normal 12px/18px OpenSansRegular;\r\n    outline: rgb(61, 61, 61) none 0px;\r\n}/*#prit_STRONG_3, #prit_STRONG_5, #prit_STRONG_7*/\r\n\r\n#prit_P_6 {\r\n    color: rgb(61, 61, 61);\r\n    height: 54px;\r\n    width: 665.40625px;\r\n    perspective-origin: 332.703125px 27px;\r\n    transform-origin: 332.703125px 27px;\r\n    border: 0px none rgb(61, 61, 61);\r\n    font: normal normal normal normal 12px/18px OpenSansRegular;\r\n    margin: 0px;\r\n    outline: rgb(61, 61, 61) none 0px;\r\n}/*#prit_P_6*/\r\n\r\n#prit_A_8 {\r\n    color: rgb(34, 148, 253);\r\n    text-decoration: none;\r\n    border: 0px none rgb(34, 148, 253);\r\n    font: normal normal normal normal 12px/18px OpenSansRegular;\r\n    outline: rgb(34, 148, 253) none 0px;\r\n}/*#prit_A_8*/\r\n\r\n#prit_BR_9, #prit_BR_10 {\r\n    color: rgb(61, 61, 61);\r\n    border: 0px none rgb(61, 61, 61);\r\n    font: normal normal normal normal 12px/18px OpenSansRegular;\r\n    outline: rgb(61, 61, 61) none 0px;\r\n}/*#prit_BR_9, #prit_BR_10*/\r\n\r\n#prit_H2_11 {\r\n    background-position: 0px 0px;\r\n    clear: both;\r\n    color: rgb(255, 255, 255);\r\n    height: 36px;\r\n    width: 652.09375px;\r\n    perspective-origin: 333.546875px 18.5px;\r\n    transform-origin: 333.546875px 18.5px;\r\n    background: rgb(0, 131, 253) none repeat scroll 0px 0px / auto padding-box border-box;\r\n    border-top: 0px none rgb(255, 255, 255);\r\n    border-right: 0px none rgb(255, 255, 255);\r\n    border-bottom: 1px solid rgb(0, 131, 253);\r\n    border-left: 0px none rgb(255, 255, 255);\r\n    font: normal normal normal normal 16px/36px OpenSansRegular;\r\n    margin: 0px 0px 15px;\r\n    outline: rgb(255, 255, 255) none 0px;\r\n    padding: 0px 0px 0px 15px;\r\n}/*#prit_H2_11*/\r\n// ]]></script>\r\n</p>\r\n<div id="prit_DIV_1">\r\n<p>GRD journals, is an open access online publication house which promotes the research works under different domains. For the research enthusiasts, the GRD Journals plays a key role of promoter. GRD journals along with the most popular indexing partners around the world puts its strong efforts for supporting an innovative, new and quality research work to reach maximum people as possible.</p>\r\n<p>The establishment of this Journal, GRD Journals is an answer to the expectations and search of many researchers and teachers in developing nations who lack free access to quality materials online. This Journal opts to bring panacea to this problem, and to encourage research development.</p>\r\n<p>GRD Journals aims to publish research articles of high quality dealing with issues which sets the new mark for outstanding developments in the field of research. Our quick interface will provide a platform to the research scholars for exchanging significant information and ideas to the world.</p>\r\n<p><strong>MISSIONS &amp; VALUES</strong></p>\r\n<p>The mission of GRD Journals is to contribute in the research and application of scientific inventions, by providing free access to research information online without any charges. All International Research Journals articles will be freely available on our website and our indexing partners. The GRD journal is ethically plead towards the noble contribution to the world in terms of knowledge.</p>\r\n<p>In addition GRD Journals is always supportive to the creative entities and their creative works and is committed to provide the best environment for letting themselves known to the world.</p>\r\n<p><strong>Benefits Choosing US:</strong></p>\r\n<ul style="list-style-type: disc;">\r\n<li>Peer based reviewing</li>\r\n<li>Reviewers from relevant field with strong academics.</li>\r\n<li>Easy, better and Fast publication</li>\r\n<li>procedure Indexing in large number of reputed indexing libraries across world.</li>\r\n<li>Providing E-Certificates and Hard Copy (Optinal)</li>\r\n</ul>\r\n</div>', 'about-us', 'about-us', 'about-us', 1, 0, 1, 1438940234, 1, 1442663125),
('authorguideline', 'Author Guideline', '', '<div id="DIV_1">\r\n<p><span style="font-size: 11pt;"><strong>Author Guidelines</strong></span></p>\r\n<p>GRD Journals is willing to publish the innovative research work and welcomes the contribution from aspiring research individuals and companies. The authors, in terms of submitting manuscripts should be aware of the following key terms and guidelines.</p>\r\n<ul>\r\n<li>The research work should be creative under the specific domain.</li>\r\n<li>The keyword should be finite (5-6 words max) and precisely related to your article subject.</li>\r\n<li>Maximum number of authors (including main and co-authors) should be 5</li>\r\n<li>-The article should be written using good word processing software(e.g. : MS-Word)</li>\r\n<li>The spelling and grammer should be maintained correctly</li>\r\n<li>The Author names should be full and in proper manner as per the manuscript templates below</li>\r\n<li>The refrences should be correct whenever its necessary. The usage of citation should be mentioned wherever its used</li>\r\n<li>The web links are allowed in article. But author should be aware of security and correctness of link.</li>\r\n<li>After writing manuscript, authors have to submit them manualy by going to article submission page.(<a href="../../page/submitmenuscript">Submit Manuscript</a>).</li>\r\n<li>The main author will be notified through e-mail about any further procedures and state of article.</li>\r\n<li>As soon as the article is reviewed by our reviewers, the author shall receive an email about the acceptance/rejaction of article.</li>\r\n<li>The author upon acceptance can go for further procedure of publishing an article. If the article is rejected the author wouldn&rsquo;t get their article published. Regarding any confusion about the acceptance/rejaction, authors are free to ask any queries on our contact nos</li>\r\n<li>The publishing procedure requires two more steps by authors 1)payment 2) copyright transfer. The author can download the Copyright transfer form from the link (<a href="../../uploads/files/GRD-copyrightform.pdf">Copyright Form</a>)</li>\r\n<li>The Authors have to make payment through an online or offline process as per their preference. In case of offline payment the author have to go nearby bank and deposite the publication charges in the account(Here) details mentioned here.</li>\r\n<li>The author after completing both the procedures may submit the proofs on the following link.</li>\r\n<li>The article after verification of payment by our entities would be put under publication.</li>\r\n<li>The authors would be notified through email after article has been published</li>\r\n<li>The authors can view their article into relevant issues.</li>\r\n<li>In order to any questions, the authors are free to ask us through mail or phone.</li>\r\n</ul>\r\n<p>Key terms:</p>\r\n<p><strong>Abstract</strong>&ndash;Short summary of an article; often included in article database searches to enable prospective readers to determine if the article is of interest. Can be structured or unstructured depending on a journal''s needs. Most types of articles require abstracts.</p>\r\n<p><strong>Accept</strong>Final decision made by journal. Acceptance means the paper is subsequently sent to production to initiate the publication phase.</p>\r\n<p><strong>Acceptance Mail- </strong>Decision Mail dispatched by editorial to author confirming willingness to publish article. The letter may be accompanied by administrative forms (e.g., copyright agreement/transfer form, color charges, offprint order form, etc.). The letter also states what the author is required to do next (e.g., return proofs in timely fashion).</p>\r\n<p><strong>Blinded-</strong>A version of the peer-review process that sees the identity of the authors hidden from reviewers. Sometimes this means the editorial office must remove the authors'' names from the manuscript. Other identifying information may also have to be removed, including the institution where the study was undertaken, grant award information, and (for medical journals) clinical trial numbers.</p>\r\n<p><strong>Copyright Agreement/Copyright Transfer Agreement-</strong>Legal document that assigns various rights to use, and re-use, content to a publisher, a journal and authors. Nearly all publications now insist such a form must be signed before publication can occur.</p>\r\n<p><strong>Corresponding Author-</strong>The author designated in the published article as the individual to contact in the event of an inquiry about a manuscript. The corresponding author normally is responsible for correcting page proofs and working with the production editor. Previously, the corresponding author may have fielded requests for article reprints, although this practice has almost disappeared.</p>\r\n<p><strong>Editor-</strong>A generic term that refers to a person/persons who possesses decision making power over the publication or rejection of content. Editors influence content direction and determine the type of material they wish to see published. They may also undertake some manuscript editing.</p>\r\n<p><strong>Editorial Board-</strong>A group of people that supports the Editor-in-Chief, and help shape the editorial direction of a journal. They may serve the journal directly by assigning reviewers to manuscripts&nbsp;or work in a more advisory capacity. The Editor-in-Chief typically calls at least one editorial board meeting annually.</p>\r\n<p><strong>Impact Factor-</strong>A measurement of the citation average of articles published in a journal. Higher citation journals typically are recognized as the most influential journals in a particular field. The size of the score can have a significant impact on the ability for journals to attract a certain quality of papers and authors. It is calculated by taking the number of citations in a calendar year to articles published in the prior two years and divided by the number of articles published in those previous two years. Several thousand journals are awarded an Impact Factor. A new Impact Factor is produced typically in June, and is now the copyright of Thomson Reuters.</p>\r\n<p><strong>Journal-</strong>A collection of papers, published as a periodical, on a particular subject. Journals range in size of circulation and volume of submissions and cover all subjects studied in academic and research settings as well as professional fields.</p>\r\n<p><strong>Manuscript-</strong>A collection of text, tables and graphic files submitted to a journal; the output from a scholarly endeavor.</p>\r\n<p><strong>Open Access-</strong>Ability for anyone to access a manuscript free of charge. Some journals offer Open Access content, with the cost burden covered by the authors. Other journals may offer some content free after a period of time. Some funding bodies (e.g., National Institutes of Health, Welcome Trust) insist that all material must be made freely available.</p>\r\n<p><strong>Open Peer Review-</strong>Ability for any individual to comment on a manuscript and make suggestions to an editor. An alternative to traditional peer review in that it is a collaborative effort rather than the closed process whereby a journal selects the reviewers. Typically authors post a manuscript for open review and then accept feedback and comments, submitting the manuscript officially sometime later</p>\r\n<p><strong>Peer Review-</strong>Evaluation of a manuscript by individuals with subject expertise. In some instances, peer reviewers know the names of authors. Under a double-blind system the author''s identity is not revealed. Under both processes, the identity of a reviewer is not normally revealed.</p>\r\n<p><strong>Plagiarism-</strong>The act of appropriating someone else s work and passing it off as your own. Journals periodically receive manuscripts containing substantial portions of text that have been copied from a previously published article. Plagiarism represents a very serious ethical offense. Authors can face significant disciplinary action if their plagiarism is uncovered</p>\r\n<p><strong>Proofreader-</strong>The proofreader is responsible for checking the page proof against the original, copy edited manuscript.</p>\r\n<p><strong>Publication Date-</strong>Date manuscript either appears in print or online. Certain databases, such as GRD Journals&nbsp;now recognize online publication as the date of official publication.</p>\r\n<p><strong>References-</strong>A section of a manuscript that lists articles cited in the main text of a manuscript.</p>\r\n<p><strong>Rejection-</strong>A decision made by a journal not to publish a manuscript. Usually this decision is rendered if the manuscript does not meet the minimum threshold for publication.</p>\r\n<p><strong>Title Page-</strong>Listing of: article title; authors and corresponding author contact information. Additionally, some journals may insist that authors also include the following on title pages: running head; conflict of interest statement; funding source declaration, acknowledgement; count of words, tables and figures</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Use of wordprocessing software</strong>&nbsp;</p>\r\n<p>It is important that the file be saved in the native format of the wordprocessor used. The text should be in single-column format. Keep the layout of the text as simple as possible.</p>\r\n<p><strong>Article structure</strong>&nbsp;<br /> <br /> Manuscripts should be prepared according to APA, 6th ed., except for the additional requirement of numbering the sections, as described below.</p>\r\n<p><em><strong>Subdivision - numbered sections</strong></em>&nbsp;<br /> Divide your article into clearly defined and numbered sections. Subsections should be numbered 1.1 (then 1.1.1, 1.1.2, ...), 1.2, etc. (the abstract is not included in section numbering). Use this numbering also for internal cross-referencing: do not just refer to ''the text''. Any subsection may be given a brief heading. Each heading should appear on its own separate line.</p>\r\n<p><em><strong>Introduction</strong></em>&nbsp;<br /> State the objectives of the work and provide an adequate background, avoiding a detailed literature survey or a summary of the results.</p>\r\n<p><em><strong>Results</strong></em>&nbsp;<br /> Results should be clear and concise.</p>\r\n<p><em><strong>Discussion</strong></em>&nbsp;<br /> This should explore the significance of the results of the work, not repeat them. Avoid extensive citations and discussion of published literature.</p>\r\n<p><em><strong>Conclusions</strong></em>&nbsp;<br /> The main conclusions of the study may be presented in a short Conclusions section, which may stand alone or form a subsection of a Discussion or Results and Discussion section.</p>\r\n<p><em><strong>Appendices</strong></em>&nbsp;<br /> If there is more than one appendix, they should be identified as A, B, etc. Formulae and equations in appendices should be given separate numbering: Eq. (A.1), Eq. (A.2), etc.; in a subsequent appendix, Eq. (B.1) and so on. Similarly for tables and figures: Table A.1; Fig. A.1, etc.</p>\r\n<p><strong>Essential title page information</strong>&nbsp;<br /> <br /> &bull;&nbsp;<strong><em>Title.</em></strong>&nbsp;Concise and informative. Titles are often used in information-retrieval systems. Avoid abbreviations and formulae where possible.<br /> &bull;&nbsp;<strong><em>Author names and affiliations.</em></strong>&nbsp;Please clearly indicate the given name(s) and family name(s) of each author and check that all names are accurately spelled. Present the authors'' affiliation addresses (where the actual work was done) below the names. Indicate all affiliations with a lower-case superscript letter immediately after the author''s name and in front of the appropriate address. Provide the full postal address of each affiliation, including the country name and, if available, the e-mail address of each author.<br /> &bull;&nbsp;<strong><em>Corresponding author.</em></strong>&nbsp;Clearly indicate who will handle correspondence at all stages of refereeing and publication, also post-publication.&nbsp;<strong>Ensure that the e-mail address is given and that contact details are kept up to date by the corresponding author.</strong></p>\r\n<p><em><strong>Abstract</strong></em>&nbsp;<br /> A concise and factual abstract is required (maximum 150 words). The abstract should state briefly the purpose of the research, the principal results and major conclusions. An abstract is often presented separately from the article, so it must be able to stand alone. For this reason, References should be avoided, but if essential, then cite the author(s) and year(s). Also, non-standard or uncommon abbreviations should be avoided, but if essential they must be defined at their first mention in the abstract itself.</p>\r\n<p><em><strong>Keywords</strong></em>&nbsp;<br /> Immediately after the abstract, provide a maximum of 5 keywords, using British or American spelling, but not a mixture of these, and avoiding general and plural terms and multiple concepts (avoid, for example, "and", "of"). Be sparing with abbreviations: only abbreviations firmly established in the field may be eligible. These keywords will be used for indexing purposes.</p>\r\n<p><strong>Abbreviations</strong>&nbsp;<br /> <br /> Define abbreviations that are not standard in this field in a footnote to be placed on the first page of the article. Such abbreviations that are unavoidable in the abstract must be defined at their first mention there, as well as in the footnote. Ensure consistency of abbreviations throughout the article.</p>\r\n<p><strong>Tables</strong>&nbsp;<br /> <br /> Please submit tables as editable text and not as images. Tables can be placed either next to the relevant text in the article, or on separate page(s) at the end. Number tables consecutively in accordance with their appearance in the text and place any table notes below the table body. Be sparing in the use of tables and ensure that the data presented in them do not duplicate results described elsewhere in the article. Please avoid using vertical rules.</p>\r\n<p><em><strong>Citation in text</strong></em>&nbsp;<br /> Please ensure that every reference cited in the text is also present in the reference list (and vice versa). Any references cited in the abstract must be given in full. Unpublished results and personal communications are not recommended in the reference list, but may be mentioned in the text. If these references are included in the reference list they should follow the standard reference style of the journal and should include a substitution of the publication date with either ''Unpublished results'' or ''Personal communication''. Citation of a reference as ''in press'' implies that the item has been accepted for publication.</p>\r\n<p><em><strong>Web references</strong></em>&nbsp;<br /> As a minimum, the full URL should be given and the date when the reference was last accessed. Any further information, if known (DOI, author names, dates, reference to a source publication, etc.), should also be given. Web references can be listed separately (e.g., after the reference list) under a different heading if desired, or can be included in the reference list.</p>\r\n<h2 id="H2_15">Manuscript Template:</h2>\r\n<p id="P_16"><a href="../../uploads/files/GRD-Journals-Paper-Template.pdf">Download the Manuscript Template</a></p>\r\n<h2 id="H2_19">Copyright Transfer Form:</h2>\r\n<p id="P_20"><a id="A_21" title="Download the Copyright Transfer Form" href="../../uploads/files/GRD-copyrightform.pdf" target="_blank">Download the Copyright Transfer Form</a></p>\r\n</div>', 'author-guideline', 'author-guideline', 'author-guideline', 1, 0, 1, 1438839611, 1, 1442558102),
('confproposal', 'Conference Proposal', '', '<p>\r\n<script>// <![CDATA[\r\n#prit_DIV_1 {\r\n    box-shadow: rgb(34, 139, 204) 0px 0px 5px 0px;\r\n    color: rgb(102, 102, 102);\r\n    float: left;\r\n    height: 1017px;\r\n    min-height: 1017px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 280px 513.5px;\r\n    transform-origin: 280px 513.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    border-radius: 4px 4px 4px 4px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 0px 0px 20px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n    padding: 5px;\r\n}/*#prit_DIV_1*/\r\n\r\n#prit_H1_2, #prit_H1_4 {\r\n    color: rgb(51, 51, 51);\r\n    height: 21px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 10.5px;\r\n    transform-origin: 275px 10.5px;\r\n    background: rgb(255, 255, 255) none repeat scroll 0% 0% / auto padding-box border-box;\r\n    border: 0px none rgb(51, 51, 51);\r\n    font: normal normal normal normal 18px/normal Georgia, ''Times New Roman'', Times, serif;\r\n    margin: 0px 0px 10px;\r\n    outline: rgb(51, 51, 51) none 0px;\r\n}/*#prit_H1_2, #prit_H1_4*/\r\n\r\n#prit_P_3 {\r\n    color: rgb(102, 102, 102);\r\n    height: 171px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 85.5px;\r\n    transform-origin: 275px 85.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_P_3*/\r\n\r\n#prit_UL_5 {\r\n    color: rgb(102, 102, 102);\r\n    height: 190px;\r\n    text-align: justify;\r\n    width: 510px;\r\n    perspective-origin: 275px 95px;\r\n    transform-origin: 275px 95px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_UL_5*/\r\n\r\n#prit_LI_6, #prit_LI_7 {\r\n    color: rgb(102, 102, 102);\r\n    height: 57px;\r\n    text-align: justify;\r\n    width: 510px;\r\n    perspective-origin: 255px 28.5px;\r\n    transform-origin: 255px 28.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_LI_6, #prit_LI_7*/\r\n\r\n#prit_LI_8, #prit_LI_9, #prit_LI_11 {\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    text-align: justify;\r\n    width: 510px;\r\n    perspective-origin: 255px 9.5px;\r\n    transform-origin: 255px 9.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_LI_8, #prit_LI_9, #prit_LI_11*/\r\n\r\n#prit_LI_10 {\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    text-align: justify;\r\n    width: 510px;\r\n    perspective-origin: 255px 9.5px;\r\n    transform-origin: 255px 9.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_LI_10*/\r\n// ]]></script>\r\n</p>\r\n<div id="prit_DIV_1">\r\n<h1>Call for Conference Proceedings</h1>\r\n<p id="prit_P_3">We GRDJournals.com offer end to end support to the organisations willing to have our support, being an association dedicated to bring our research work online in the best possible way we are here to help those who are in need of support.</p>\r\n<p>Once the proposal to support a conference is approved by our editorial board we start working with the conference team to promote their conference through our site and in all possible ways.</p>\r\n<p>We are sure that with our experience in conducting conferences we can support any academic conference in a better way. We provide the following service to the conference organisers so that their conference is promoted in a better way.</p>\r\n</div>', 'conference-proposal', 'conference-proposal', 'conference-proposal', 0, 0, 1, 1438923988, 1, 1442556966),
('contactus', 'Contact Us', '', '<p>\r\n<script>// <![CDATA[\r\n#prit_TABLE_1 {\r\n    border-collapse: collapse;\r\n    color: rgb(51, 51, 51);\r\n    height: 117px;\r\n    vertical-align: top;\r\n    width: 699px;\r\n    perspective-origin: 350px 59px;\r\n    transform-origin: 350px 59px;\r\n    border: 1px solid rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 16px/normal verdana, Arial, Helvetica, sans-serif;\r\n    margin: 0px 0px 15px;\r\n    outline: rgb(51, 51, 51) none 0px;\r\n}/*#prit_TABLE_1*/\r\n\r\n#prit_TBODY_2 {\r\n    border-collapse: collapse;\r\n    color: rgb(51, 51, 51);\r\n    height: 117px;\r\n    width: 699px;\r\n    perspective-origin: 349.5px 58.5px;\r\n    transform-origin: 349.5px 58.5px;\r\n    border: 0px none rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 16px/normal verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(51, 51, 51) none 0px;\r\n}/*#prit_TBODY_2*/\r\n\r\n#prit_TR_3 {\r\n    border-collapse: collapse;\r\n    color: rgb(102, 102, 102);\r\n    height: 30px;\r\n    vertical-align: middle;\r\n    width: 699px;\r\n    perspective-origin: 349.5px 15px;\r\n    transform-origin: 349.5px 15px;\r\n    background: rgb(206, 236, 255) none repeat scroll 0% 0% / auto padding-box border-box;\r\n    border: 0px none rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_TR_3*/\r\n\r\n#prit_TD_4 {\r\n    border-collapse: collapse;\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    vertical-align: top;\r\n    width: 149px;\r\n    perspective-origin: 80px 15px;\r\n    transform-origin: 80px 15px;\r\n    border-top: 0px none rgb(102, 102, 102);\r\n    border-right: 1px solid rgb(204, 204, 204);\r\n    border-bottom: 0px none rgb(102, 102, 102);\r\n    border-left: 1px solid rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n    padding: 5px;\r\n}/*#prit_TD_4*/\r\n\r\n#prit_TD_5 {\r\n    border-collapse: collapse;\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    vertical-align: top;\r\n    width: 528px;\r\n    perspective-origin: 269.5px 15px;\r\n    transform-origin: 269.5px 15px;\r\n    border-top: 0px none rgb(102, 102, 102);\r\n    border-right: 1px solid rgb(204, 204, 204);\r\n    border-bottom: 0px none rgb(102, 102, 102);\r\n    border-left: 1px solid rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n    padding: 5px;\r\n}/*#prit_TD_5*/\r\n\r\n#prit_TR_6, #prit_TR_13 {\r\n    border-collapse: collapse;\r\n    color: rgb(102, 102, 102);\r\n    height: 29px;\r\n    vertical-align: middle;\r\n    width: 699px;\r\n    perspective-origin: 349.5px 14.5px;\r\n    transform-origin: 349.5px 14.5px;\r\n    background: rgb(232, 246, 255) none repeat scroll 0% 0% / auto padding-box border-box;\r\n    border: 0px none rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_TR_6, #prit_TR_13*/\r\n\r\n#prit_TD_7, #prit_TD_10, #prit_TD_14 {\r\n    border-collapse: collapse;\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    vertical-align: top;\r\n    width: 149px;\r\n    perspective-origin: 80px 14.5px;\r\n    transform-origin: 80px 14.5px;\r\n    border-top: 0px none rgb(102, 102, 102);\r\n    border-right: 1px solid rgb(204, 204, 204);\r\n    border-bottom: 0px none rgb(102, 102, 102);\r\n    border-left: 1px solid rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n    padding: 5px;\r\n}/*#prit_TD_7, #prit_TD_10, #prit_TD_14*/\r\n\r\n#prit_TD_8, #prit_TD_11, #prit_TD_15 {\r\n    border-collapse: collapse;\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    vertical-align: top;\r\n    width: 528px;\r\n    perspective-origin: 269.5px 14.5px;\r\n    transform-origin: 269.5px 14.5px;\r\n    border-top: 0px none rgb(102, 102, 102);\r\n    border-right: 1px solid rgb(204, 204, 204);\r\n    border-bottom: 0px none rgb(102, 102, 102);\r\n    border-left: 1px solid rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n    padding: 5px;\r\n}/*#prit_TD_8, #prit_TD_11, #prit_TD_15*/\r\n\r\n#prit_TR_9 {\r\n    border-collapse: collapse;\r\n    color: rgb(102, 102, 102);\r\n    height: 29px;\r\n    vertical-align: middle;\r\n    width: 699px;\r\n    perspective-origin: 349.5px 14.5px;\r\n    transform-origin: 349.5px 14.5px;\r\n    background: rgb(206, 236, 255) none repeat scroll 0% 0% / auto padding-box border-box;\r\n    border: 0px none rgb(204, 204, 204);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_TR_9*/\r\n\r\n#prit_A_12 {\r\n    border-collapse: collapse;\r\n    color: rgb(116, 101, 80);\r\n    text-decoration: none;\r\n    border: 0px none rgb(116, 101, 80);\r\n    border-spacing: 2px 2px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(116, 101, 80) none 0px;\r\n}/*#prit_A_12*/\r\n// ]]></script>\r\n</p>\r\n<table id="prit_TABLE_1" style="height: 86px;" width="517">\r\n<tbody id="prit_TBODY_2">\r\n<tr id="prit_TR_3">\r\n<td id="prit_TD_4">Publisher</td>\r\n<td id="prit_TD_5">GRD Journals</td>\r\n</tr>\r\n<tr id="prit_TR_6">\r\n<td id="prit_TD_7">&nbsp;</td>\r\n<td id="prit_TD_8">&nbsp;</td>\r\n</tr>\r\n<tr id="prit_TR_9">\r\n<td id="prit_TD_10">Email Id</td>\r\n<td id="prit_TD_11">grdjournals@gmail.com</td>\r\n</tr>\r\n<tr id="prit_TR_13">\r\n<td id="prit_TD_14">&nbsp;</td>\r\n<td id="prit_TD_15">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', 'contact-us', 'contact-us', 'contact-us', 1, 0, 1, 1438940462, 1, 1442557283),
('editorialboard', 'Editorial Board', '', '<div id="prit_DIV_1">&nbsp;</div>', 'editorial-board', 'editorial-board', 'editorial-board', 1, 0, 1, 1438937787, 1, 1442512141),
('faq', 'Frequenty Asked Questions', '', '<p>\r\n<script>// <![CDATA[\r\n#prit_DIV_1 {\r\n    box-shadow: rgb(34, 139, 204) 0px 0px 5px 0px;\r\n    color: rgb(102, 102, 102);\r\n    float: left;\r\n    height: 1371px;\r\n    min-height: 1017px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 280px 690.5px;\r\n    transform-origin: 280px 690.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    border-radius: 4px 4px 4px 4px;\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 0px 0px 20px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n    padding: 5px;\r\n}/*#prit_DIV_1*/\r\n\r\n#prit_H1_2 {\r\n    color: rgb(51, 51, 51);\r\n    height: 21px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 10.5px;\r\n    transform-origin: 275px 10.5px;\r\n    background: rgb(255, 255, 255) none repeat scroll 0% 0% / auto padding-box border-box;\r\n    border: 0px none rgb(51, 51, 51);\r\n    font: normal normal normal normal 18px/normal Georgia, ''Times New Roman'', Times, serif;\r\n    margin: 0px 0px 10px;\r\n    outline: rgb(51, 51, 51) none 0px;\r\n}/*#prit_H1_2*/\r\n\r\n#prit_B_3, #prit_B_5, #prit_B_7, #prit_B_9, #prit_B_11, #prit_B_13, #prit_B_19, #prit_B_21, #prit_B_23, #prit_B_25, #prit_B_27, #prit_B_29, #prit_B_31, #prit_B_33, #prit_B_35 {\r\n    color: rgb(102, 102, 102);\r\n    text-align: justify;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal bold normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_B_3, #prit_B_5, #prit_B_7, #prit_B_9, #prit_B_11, #prit_B_13, #prit_B_19, #prit_B_21, #prit_B_23, #prit_B_25, #prit_B_27, #prit_B_29, #prit_B_31, #prit_B_33, #prit_B_35*/\r\n\r\n#prit_P_4, #prit_P_22 {\r\n    color: rgb(102, 102, 102);\r\n    height: 38px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 19px;\r\n    transform-origin: 275px 19px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_P_4, #prit_P_22*/\r\n\r\n#prit_P_6, #prit_P_10, #prit_P_20, #prit_P_28, #prit_P_34 {\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 9.5px;\r\n    transform-origin: 275px 9.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_P_6, #prit_P_10, #prit_P_20, #prit_P_28, #prit_P_34*/\r\n\r\n#prit_P_8, #prit_P_26 {\r\n    color: rgb(102, 102, 102);\r\n    height: 57px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 28.5px;\r\n    transform-origin: 275px 28.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_P_8, #prit_P_26*/\r\n\r\n#prit_P_12, #prit_P_30, #prit_P_36 {\r\n    color: rgb(102, 102, 102);\r\n    height: 19px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 9.5px;\r\n    transform-origin: 275px 9.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_P_12, #prit_P_30, #prit_P_36*/\r\n\r\n#prit_P_14 {\r\n    color: rgb(102, 102, 102);\r\n    height: 95px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 47.5px;\r\n    transform-origin: 275px 47.5px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_P_14*/\r\n\r\n#prit_BR_15, #prit_BR_16, #prit_BR_18 {\r\n    color: rgb(102, 102, 102);\r\n    text-align: justify;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_BR_15, #prit_BR_16, #prit_BR_18*/\r\n\r\n#prit_BR_17 {\r\n    color: rgb(102, 102, 102);\r\n    text-align: justify;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_BR_17*/\r\n\r\n#prit_P_24, #prit_P_32 {\r\n    color: rgb(102, 102, 102);\r\n    height: 114px;\r\n    text-align: justify;\r\n    width: 550px;\r\n    perspective-origin: 275px 57px;\r\n    transform-origin: 275px 57px;\r\n    border: 0px none rgb(102, 102, 102);\r\n    font: normal normal normal normal 13px/19.5px verdana, Arial, Helvetica, sans-serif;\r\n    margin: 13px 0px;\r\n    outline: rgb(102, 102, 102) none 0px;\r\n}/*#prit_P_24, #prit_P_32*/\r\n// ]]></script>\r\n</p>\r\n<div id="prit_DIV_1"><strong id="prit_B_3">How can I submit my manuscript to GRD Journals?</strong>\r\n<p id="prit_P_4">You can submit your paper to the GRD Journals through online or on e-mail at: info@GRD Journals.com</p>\r\n<strong id="prit_B_5">Can I submit more than one paper for the same issue?</strong>\r\n<p id="prit_P_6">Yes, you can submit more than one paper at a time.</p>\r\n<strong id="prit_B_7">How much time does GRD Journals take in review process?</strong>\r\n<p id="prit_P_8">The editorial board is highly committed to the quick review process of the paper, but not with the sacrifice of the right judgment of a paper. The review process takes maximum Five days.</p>\r\n<strong id="prit_B_9">What is the frequency of publication of GRD Journals?</strong>\r\n<p id="prit_P_10">GRD Journals is monthly journal. It publishes one issue per month.</p>\r\n<strong id="prit_B_11">When I will get the acceptance letter, if my paper is accepted?</strong>\r\n<p id="prit_P_12">Acceptance letter is provided after completion of reviewing process.</p>\r\n<strong id="prit_B_13">How can I pay the publication fee?</strong>\r\n<p id="prit_P_14">You can pay publication fess by three ways.<br id="prit_BR_15" /> Payment through Bank account transfer to Any BANK (NEFT)<br id="prit_BR_16" /> Payment by direct (Cash) deposit of fess in Account<br id="prit_BR_17" /> Payment through Demand Draft.<br id="prit_BR_18" /> For foreign author payment can be done by &lsquo;PayPal&rsquo;</p>\r\n<strong id="prit_B_19">Where can I find Copyrights Transfer Form?</strong>\r\n<p id="prit_P_20">Copyrights Transfer form is available on www.GRDJournals.com.</p>\r\n<strong id="prit_B_21">Is there any restriction for number of pages and fee for extra pages?</strong>\r\n<p id="prit_P_22">Minimum 2 pages and Maximum 5 pages are allowed. If it exceeds 5, remaining will be charged Rs. 100 per page.</p>\r\n<strong id="prit_B_23">Why should i transfer copyrights to GRD Journals?</strong>\r\n<p id="prit_P_24">Like many other scientific publishers, the GRD Journals requires authors to provide transfer of copyright prior to publication. This permits GRD Journals to publish the article and to defend against improper use i. e. publishing in other journals. It also permits GRD Journals to mount the article online and to use the article in other forms or media. By the GRD Journals transfer agreement, authors retain substantial rights in the work.</p>\r\n<strong id="prit_B_25">How does the review process work?</strong>\r\n<p id="prit_P_26">The review of articles is done through a blind peer review. All the articles received by GRD Journals are sending to Review Committee after deleting the name of the author to have an unbiased opinion about the research.</p>\r\n<strong id="prit_B_27">How long my published paper will be Online?</strong>\r\n<p id="prit_P_28">Lifetime</p>\r\n<strong id="prit_B_29">Is there a template available for paper format?</strong>\r\n<p id="prit_P_30">Yes, you can download paper format from our website.</p>\r\n<strong id="prit_B_31">How can I join GRD Journals as a reviewer?</strong>\r\n<p id="prit_P_32">The GRD Journals is an open membership organization. It is a small working group of general Engineering Streams Journals. Occasionally, the GRD Journals will invite a new member or guest when the committee feels that the new journal or organization will provide a needed perspective that is not already available within the existing committee. Open membership organizations for editors and others in Engineering.To join please visit www.GRDJournals.com</p>\r\n<strong id="prit_B_33">How can I check status of my paper?</strong>\r\n<p id="prit_P_34">You may check your paper status by clicking on following link.</p>\r\n<strong id="prit_B_35">I did not find my question on your FAQ list.</strong>\r\n<p id="prit_P_36">Kindly send a mail to info@grdjournals.com</p>\r\n</div>', 'faq', 'faq', 'faq', 1, 0, 1, 1438939620, 1, 1442552710),
('grdjeabout', 'GRD Journal for Engineering', '', '<p>GRD Journal for Engineering&nbsp; (GRDJE)&nbsp; is an uprising peer-reviewed journal in the field of engineering journal. With simple procedure GRDJE provides a best framework to publish the quality research articles and gives it a global recognition. With a simple manuscript submission procedure GRDJE removes the overburden of complex things from authors through automatic procedure. In addition the review is done by professionals with strong educational background who thoroughly reviews your paper and gives the perfact analysis and suggestions if needed to improvise your research.</p>\r\n<p>The GRD Journals automated process makes faster publication with indexing into global libraries.</p>\r\n<p><strong>BENEFITS of GRDJE</strong></p>\r\n<ul style="list-style-type: square;">\r\n<li>Fast review process, peer-reviewed, security, flexible payment mathods,&nbsp; strong support, automated paper status, email and sms notification, open journal, strong review panel.</li>\r\n</ul>\r\n<ul style="list-style-type: square;">\r\n<li>So what are you waiting for, we highly appreciate the creative research and believe giving the new researchers chance.</li>\r\n</ul>\r\n<p><strong>Hurry... Free Publication&nbsp;</strong></p>\r\n<ul>\r\n<li>As for the first 2 month of starting up GRDJE wants to give free publication to authors. In return Grd is committed to give you e certificate of publication and publishing on our site plus the indexing libraries. this offer is available before 25th November 2015.</li>\r\n</ul>', 'grdje/about', 'GRD Journal for Engineering', 'GRD Journal for Engineering', 1, 0, 1, 1442672212, 1, 1442683727),
('grdjecharges', 'Grd Journals of Engineering - Publication Charges', '', '<p>Grd Journals of Engineering - Publication Charges</p>', 'grdje/publication-charges', 'Grd Journals of Engineering - Publication Charges', 'Grd Journals of Engineering - Publication Charges', 1, 0, 1, 1442686786, 1, 1442686786),
('grdjeresearcharea', 'GRD Journals For Engineering Research Area', '', '<div id="prit_DIV_1">\r\n<ul id="prit_UL_3">\r\n<li id="prit_LI_4">Mechanical Engineering</li>\r\n<li id="prit_LI_5">Electrical Engineering</li>\r\n<li id="prit_LI_6">Computer Engineering</li>\r\n<li id="prit_LI_7">Software Engineering</li>\r\n<li id="prit_LI_8">Electronics &amp; Communication Engineering</li>\r\n<li id="prit_LI_9">Environment Engineering</li>\r\n<li id="prit_LI_10">Telecommunication Engineering</li>\r\n<li id="prit_LI_11">Engineering Mathematics</li>\r\n<li id="prit_LI_12">Civil Engineering</li>\r\n<li id="prit_LI_13">Electromechanical System Engineering</li>\r\n<li id="prit_LI_14">Chemical Engineering</li>\r\n<li id="prit_LI_15">Agricultural Engineering</li>\r\n<li id="prit_LI_16">Biological &amp; Bio system Engineering</li>\r\n<li id="prit_LI_17">Food Engineering</li>\r\n<li id="prit_LI_18">Forestry Engineering</li>\r\n<li id="prit_LI_19">Materials Engineering</li>\r\n<li id="prit_LI_20">Water Resource Engineering</li>\r\n<li id="prit_LI_21">Mineral &amp; Metallurgical Engineering</li>\r\n<li id="prit_LI_22">Architecture &amp; Planning</li>\r\n<li id="prit_LI_23">Natural Sciences, Humanities</li>\r\n<li id="prit_LI_24">Engineering Management</li>\r\n<li id="prit_LI_25">Engineering Sciences</li>\r\n<li id="prit_LI_26">Aerospace Engineering</li>\r\n<li id="prit_LI_27">Automotive Engineering</li>\r\n<li id="prit_LI_28">Naval Architectural Engineering</li>\r\n<li id="prit_LI_29">Bio mechanical&amp; Biomedical Engineering</li>\r\n<li id="prit_LI_30">Geo Technical Engineering</li>\r\n<li id="prit_LI_31">Gas Engineering</li>\r\n<li id="prit_LI_32">Geological Engineering</li>\r\n<li id="prit_LI_33">Mining Engineering</li>\r\n<li id="prit_LI_34">Oil Engineering</li>\r\n<li id="prit_LI_35">Petroleum Engineering</li>\r\n<li id="prit_LI_36">Engineering Chemistry</li>\r\n<li id="prit_LI_37">Engineering Maths</li>\r\n<li id="prit_LI_38">Engineering Physics</li>\r\n<li id="prit_LI_39">Integrated Engineering</li>\r\n<li id="prit_LI_40">Industrial Engineering</li>\r\n<li id="prit_LI_41">Production Engineering</li>\r\n<li id="prit_LI_42">System Engineering</li>\r\n<li id="prit_LI_43">Aeronautical Engineering</li>\r\n<li id="prit_LI_44">Audio Engineering</li>\r\n<li id="prit_LI_45">Chassis Engineering</li>\r\n<li id="prit_LI_46">Electronics Engineering</li>\r\n<li id="prit_LI_47">Forensic Engineering</li>\r\n<li id="prit_LI_48">Manufacturing Engineering</li>\r\n<li id="prit_LI_49">Marine Engineering</li>\r\n<li id="prit_LI_50">Model Engineering</li>\r\n<li id="prit_LI_51">Nuclear Engineering</li>\r\n<li id="prit_LI_52">Ocean Engineering</li>\r\n<li id="prit_LI_53">Sound Engineering</li>\r\n<li id="prit_LI_54">Structural Engineering</li>\r\n<li id="prit_LI_55">Textile Engineering</li>\r\n<li id="prit_LI_56">Rubber Technology</li>\r\n<li id="prit_LI_57">Applied Science</li>\r\n</ul>\r\n</div>', 'grdje/research-area', 'GRD Journals For Engineering Research Area', 'GRD Journals For Engineering Research Area', 1, 0, 1, 1442684013, 1, 1442684013),
('grdjesubmit', 'Grd Journals of Engineering - Submit An Article', '', '<p><span style="font-size: 24pt;">This page is dynamic - Nothing to change.</span></p>', 'grdje/submit-an-article', 'Grd Journals of Engineering - Submit An Article', 'Grd Journals of Engineering - Submit An Article', 1, 0, 1, 1442685343, 1, 1442685343),
('index', 'GRD Journals', '', '<p>GRD journals, is an open access online publication house which promotes the research works under different domains. For the research enthusiasts, the GRD Journals plays a key role of promoter. GRD journals along with the most popular indexing partners around the world puts its strong efforts for supporting an innovative, new and quality research work to reach maximum people as possible.</p>\r\n<p>The establishment of this Journal, GRD Journals is an answer to the expectations and search of many researchers and teachers in developing nations who lack free access to quality materials online. This Journal opts to bring panacea to this problem, and to encourage research development.</p>\r\n<p>GRD Journals aims to publish research articles of high quality dealing with issues which sets the new mark for outstanding developments in the field of research. Our quick interface will provide a platform to the research scholars for exchanging significant information and ideas to the world.</p>\r\n<p><a title="GRD Journals" href="../../about-us">Read more about our mission , values and benefits.</a></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<ul class="nav padding-10">\r\n<li><a class="alert alert-success">List of Journal</a></li>\r\n</ul>\r\n<ul class="nav padding-10">\r\n<li><a class="alert alert-info" href="../../grdje/about">GRD Journals of Engineering</a></li>\r\n</ul>', 'index', 'index', 'index', 1, 0, 1, 1438767435, 1, 1442682523);
INSERT INTO `cms` (`id`, `page_title`, `page_name`, `content`, `slug`, `meta_key`, `meta_description`, `status`, `is_deleted`, `created_by`, `created_dt`, `updated_by`, `updated_dt`) VALUES
('paperformat', 'Paper Format', '', '<table>\r\n<tbody>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><strong>Paper/Manuscript Title</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><strong>&nbsp;</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; First Author&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><em>Designation of Author(PG Student, Assistant Professor etc.,)</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><em>Affiliated</em><em>Department of (Civil, Mechanical, Electrical etc.,) Engineering</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><em>Institute/Industry /College/University Name</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><em>&nbsp;</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><strong>Second Author</strong></p>\r\n</td>\r\n<td width="347">\r\n<p><strong>Third Author</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><em>Designation of Author( PG Student, Assistant Professor etc.,)</em></p>\r\n</td>\r\n<td width="347">\r\n<p><em>Designation of Author(PG Student, Assistant Professor etc.,)</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><em>Affiliated</em><em>Department of (Civil, Mechanical, Electrical etc.,) Engineering</em></p>\r\n</td>\r\n<td width="347">\r\n<p><em>Affiliated</em><em>Department of (Civil, Mechanical, Electrical etc.,) Engineering</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><em>Institute/Industry /College/University Name</em></p>\r\n</td>\r\n<td width="347">\r\n<p><em>Institute/Industry /College/University Name</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><em>&nbsp;</em></p>\r\n</td>\r\n<td width="347">\r\n<p><em>&nbsp;</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><strong>Fourth Author</strong></p>\r\n</td>\r\n<td width="347">\r\n<p><strong>Fifth Author</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><em>Designation of Author(PG Student, Assistant Professor etc.,)</em></p>\r\n</td>\r\n<td width="347">\r\n<p><em>Designation of Author(PG Student, Assistant Professor etc.,)</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><em>Affiliated</em><em>Department of (Civil, Mechanical, Electrical etc.,) Engineering</em></p>\r\n</td>\r\n<td width="347">\r\n<p><em>Affiliated</em><em>Department of (Civil, Mechanical, Electrical etc.,) Engineering</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><em>Institute/Industry /College/University Name</em></p>\r\n</td>\r\n<td width="347">\r\n<p><em>Institute/Industry /College/University Name</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width="344">\r\n<p><strong>&nbsp;</strong></p>\r\n</td>\r\n<td width="347">\r\n<p><em>&nbsp;</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" width="691">\r\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Abstract&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>This document gives formatting instructions for authors preparing papers for publication in the Proceedings of an conference. The authors must follow the instructions given in the document for the papers to be published. You can use this document as both an instruction set and as a template into which you can type your own text.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<p><strong>Keywords- Include at least 5 keywords or phrases</strong>__________________________________________________________________________________________________</p>\r\n<h1>I.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Introduction</h1>\r\n<p>When Author goes for GRD Journals Template then they can use page layout view from the view and they can use MS Word for making their manuscript. Authors have to writing their research work in this paragraph without any space. They have to use times new roman font for making this paragraph and font should be in 10mm size.it is simple normal word not use any kind of word like italic, bold etc.,</p>\r\n<p>Author can add there images and research work also.</p>\r\n<h1>II.&nbsp;&nbsp;&nbsp; Author Guideline for manuscript preparation</h1>\r\n<h2><em>A.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em><em>Sub point of Topic</em></h2>\r\n<p>Author can write there abbreviation and their work which is related to them work.These all word should be in 10mm size. You can describe your topic details with your own word which you do in your work while doing your research that things you have to put here.</p>\r\n<p>This is paragraph for more information of your related work which u can write it here.</p>\r\n<h3><em>1)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em><em>One Another Sub Point in Sub Point</em></h3>\r\n<p>Use your topic in this sub topic that you can use with your research work detail about those topics.</p>\r\n<h2><em>B.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em><em>Other Recommendation of Sub Topic</em></h2>\r\n<p>If you can use your work here for providing related topics details.</p>\r\n<h1>III. Mathematics</h1>\r\n<p>Here you can use your mathematics word related your work which should be in 10mm size. Here you can put anything which are related to work with mathematics related also and not only mathematics word but you can put your related research work also. if it is in English word or whatever words. You can write it down.</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------- (1)</p>\r\n<p>Author can add there images and research work also.</p>\r\n<p>Fig. 1: about figure</p>\r\n<p>In Image Caption Size should be in 9mm size and it should be in center and 6point space after figure name.</p>\r\n<p>&nbsp;</p>\r\n<p><em>Table 1: Table Name</em></p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p><em>SR. No</em></p>\r\n</td>\r\n<td>\r\n<p><em>Quantity Name</em></p>\r\n</td>\r\n<td>\r\n<p><em>Description</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><em>1</em></p>\r\n</td>\r\n<td>\r\n<p><em>Inlet Diameter</em></p>\r\n</td>\r\n<td>\r\n<p><em>2 mm</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><em>2</em></p>\r\n</td>\r\n<td>\r\n<p><em>Total Diameter</em></p>\r\n</td>\r\n<td>\r\n<p><em>10 mm</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><em>3</em></p>\r\n</td>\r\n<td>\r\n<p><em>Cold outlet Diameter</em></p>\r\n</td>\r\n<td>\r\n<p><em>5 mm</em></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p><em>4</em></p>\r\n</td>\r\n<td>\r\n<p><em>Number of Nozzles</em></p>\r\n</td>\r\n<td>\r\n<p><em>6</em></p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>In table all words should be in 9mm size and italic also</p>\r\n<h1>IV. &nbsp;Guideline for more Preparation</h1>\r\n<h2><em>A.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em><em>Types of Data</em></h2>\r\n<p>Authors have to right down their Graphical represented work also.</p>\r\n<p>They are submitting their related work in GRD Journals.</p>\r\n<h2><em>B.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em><em>Using Figure</em></h2>\r\n<p>Authors can submit their figure with their sub topic also.</p>\r\n<h3><em>1)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </em><em>Subtopic</em></h3>\r\n<p>You can use your point as bullet also which should be in (-).</p>\r\n<ul>\r\n<li>Good work</li>\r\n<li>Great work</li>\r\n</ul>\r\n<p>Your point related in number then it should be in numbering also.</p>\r\n<ul>\r\n<li>Good work</li>\r\n<li>Great work</li>\r\n</ul>\r\n<h1>V.&nbsp;&nbsp;&nbsp; Conclusions</h1>\r\n<p>In the light of the journals, the modeling of the vortex tube was conducted and based upon the analysis we reached at the conclusion that the system can be used as an ideal replacement for the conventional air conditioning unit in automobiles. The proposed system adheres to all conventional rules and is more economic than the normal automobile air conditioning unit. Through the proposed system we can reduce the engine load to a certain extend causing the engine to work at a better pace and performance than the normal engine.</p>\r\n<p>From the studies conducted we also plan to conduct a further study regarding the application of our technology in the practical air conditioning and radiator cooling unit.</p>\r\n<h1>Appendix</h1>\r\n<p>If needed then you can put it before references.</p>\r\n<h1>Acknowledgment</h1>\r\n<p>The authors would like to acknowledge the support of&nbsp;&nbsp; Mechanical Engineering Department of Saintgits College of Engineering for conductingthe present investigation.</p>\r\n<h1>References</h1>\r\n<p><strong><em>Book References</em></strong></p>\r\n<ul>\r\n<li>Author 1, Author 2 , &ldquo;Manuscript Title&rdquo;, Journals Name, Vol. xx, Issue xx, Year, page. 1-4.</li>\r\n<li>John Doe, M. kelvin &ldquo;Review on A Controlling of an Industrial Robotic ARM&rdquo;, Journal, Vol. xx, Issue xx ,year,&nbsp;&nbsp; pp.1-6.</li>\r\n<li>Manas z , Jemco c, Liza k., &ldquo;A framework for clustering evolving data streams&rdquo;,Journal for XYZ,Vol.xx, Issue XX, , pp. 1-8</li>\r\n</ul>\r\n<p><strong><em>Website References</em></strong></p>\r\n<ul>\r\n<li>grdjournals.com</li>\r\n<li>.reffrenceWebsite.com</li>\r\n</ul>\r\n<p><strong><em> Example</em></strong></p>\r\n<ul>\r\n<li>grdjournals.com</li>\r\n<li>.reffrenceWebsite.com</li>\r\n</ul>', 'paperformat', 'paper format', 'paperformat', 1, 0, 1, 1442513592, 1, 1442513592);

-- --------------------------------------------------------

--
-- Table structure for table `coauthor`
--

CREATE TABLE IF NOT EXISTS `coauthor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `org` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `iso` varchar(45) DEFAULT NULL,
  `iso3` varchar(45) DEFAULT NULL,
  `fips` varchar(45) DEFAULT NULL,
  `country_name` varchar(45) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `currency_code` varchar(45) DEFAULT NULL,
  `currency_name` varchar(45) DEFAULT NULL,
  `phone_prefix` varchar(45) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  `languages` varchar(45) DEFAULT NULL,
  `geonameid` varchar(45) DEFAULT NULL,
  `ip_address` varchar(25) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='country' AUTO_INCREMENT=895 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `iso`, `iso3`, `fips`, `country_name`, `region_id`, `currency_code`, `currency_name`, `phone_prefix`, `postal_code`, `languages`, `geonameid`, `ip_address`, `status`, `is_deleted`, `created_date`, `created_by`, `updated_date`, `updated_by`) VALUES
(4, 'AF', 'AFG', 'AF', 'Afghanistan', 1, 'AFN', 'Afghani', '+93', '', 'fa-AF,ps,uz-AF,tk', '1149361', '', 1, 0, 0, 0, 0, 0),
(8, 'AL', 'ALB', 'AL', 'Albania', 5, 'ALL', 'Lek', '+355', '', 'sq,el', '783754', '', 1, 0, 0, 0, 0, 0),
(10, 'AQ', 'ATA', 'AY', 'Antarctica', 3, '', '', '+', '', '', '6697173', '', 1, 0, 0, 0, 0, 0),
(12, 'DZ', 'DZA', 'AG', 'Algeria', 2, 'DZD', 'Dinar', '+213', '^(d{5})$', 'ar-DZ', '2589581', '', 1, 0, 0, 0, 0, 0),
(16, 'AS', 'ASM', 'AQ', 'American Samoa', 4, 'USD', 'Dollar', '+1-684', '', 'en-AS,sm,to', '5880801', '', 1, 0, 0, 0, 0, 0),
(20, 'AD', 'AND', 'AN', 'Andorra', 5, 'EUR', 'Euro', '+376', '^(?:AD)*(d{3})$', 'ca,fr-AD,pt', '3041565', '', 1, 0, 0, 0, 0, 0),
(24, 'AO', 'AGO', 'AO', 'Angola', 2, 'AOA', 'Kwanza', '+244', '', 'pt-AO', '3351879', '', 1, 0, 0, 0, 0, 0),
(28, 'AG', 'ATG', 'AC', 'Antigua and Barbuda', 6, 'XCD', 'Dollar', '+1-268', '', 'en-AG', '3576396', '', 1, 0, 0, 0, 0, 0),
(31, 'AZ', 'AZE', 'AJ', 'Azerbaijan', 1, 'AZN', 'Manat', '+994', '^(?:AZ)*(d{4})$', 'az,ru,hy', '587116', '', 1, 0, 0, 0, 0, 0),
(32, 'AR', 'ARG', 'AR', 'Argentina', 7, 'ARS', 'Peso', '+54', '^([A-Z]d{4}[A-Z]{3})$', 'es-AR,en,it,de,fr', '3865483', '', 1, 0, 0, 0, 0, 0),
(36, 'AU', 'AUS', 'AS', 'Australia', 4, 'AUD', 'Dollar', '+61', '^(d{4})$', 'en-AU', '2077456', '', 1, 0, 0, 0, 0, 0),
(40, 'AT', 'AUT', 'AU', 'Austria', 5, 'EUR', 'Euro', '+43', '^(d{4})$', 'de-AT,hr,hu,sl', '2782113', '', 1, 0, 0, 0, 0, 0),
(44, 'BS', 'BHS', 'BF', 'Bahamas', 6, 'BSD', 'Dollar', '+1-242', '', 'en-BS', '3572887', '', 1, 0, 0, 0, 0, 0),
(48, 'BH', 'BHR', 'BA', 'Bahrain', 1, 'BHD', 'Dinar', '+973', '^(d{3}d?)$', 'ar-BH,en,fa,ur', '290291', '', 1, 0, 0, 0, 0, 0),
(50, 'BD', 'BGD', 'BG', 'Bangladesh', 1, 'BDT', 'Taka', '+880', '^(d{4})$', 'bn-BD,en', '1210997', '', 1, 0, 0, 0, 0, 0),
(51, 'AM', 'ARM', 'AM', 'Armenia', 1, 'AMD', 'Dram', '+374', '^(d{6})$', 'hy', '174982', '', 1, 0, 0, 0, 0, 0),
(52, 'BB', 'BRB', 'BB', 'Barbados', 6, 'BBD', 'Dollar', '+1-246', '^(?:BB)*(d{5})$', 'en-BB', '3374084', '', 1, 0, 0, 0, 0, 0),
(56, 'BE', 'BEL', 'BE', 'Belgium', 5, 'EUR', 'Euro', '+32', '^(d{4})$', 'nl-BE,fr-BE,de-BE', '2802361', '', 1, 0, 0, 0, 0, 0),
(60, 'BM', 'BMU', 'BD', 'Bermuda', 6, 'BMD', 'Dollar', '+1-441', '^([A-Z]{2}d{2})$', 'en-BM,pt', '3573345', '', 1, 0, 0, 0, 0, 0),
(64, 'BT', 'BTN', 'BT', 'Bhutan', 1, 'BTN', 'Ngultrum', '+975', '', 'dz', '1252634', '', 1, 0, 0, 0, 0, 0),
(68, 'BO', 'BOL', 'BL', 'Bolivia', 7, 'BOB', 'Boliviano', '+591', '', 'es-BO,qu,ay', '3923057', '', 1, 0, 0, 0, 0, 0),
(70, 'BA', 'BIH', 'BK', 'Bosnia and Herzegovina', 5, 'BAM', 'Marka', '+387', '^(d{5})$', 'bs,hr-BA,sr-BA', '3277605', '', 1, 0, 0, 0, 0, 0),
(72, 'BW', 'BWA', 'BC', 'Botswana', 2, 'BWP', 'Pula', '+267', '', 'en-BW,tn-BW', '933860', '', 1, 0, 0, 0, 0, 0),
(74, 'BV', 'BVT', 'BV', 'Bouvet Island', 3, 'NOK', 'Krone', '+', '', '', '3371123', '', 1, 0, 0, 0, 0, 0),
(76, 'BR', 'BRA', 'BR', 'Brazil', 7, 'BRL', 'Real', '+55', '^(d{8})$', 'pt-BR,es,en,fr', '3469034', '', 1, 0, 0, 0, 0, 0),
(84, 'BZ', 'BLZ', 'BH', 'Belize', 6, 'BZD', 'Dollar', '+501', '', 'en-BZ,es', '3582678', '', 1, 0, 0, 0, 0, 0),
(86, 'IO', 'IOT', 'IO', 'British Indian Ocean Territory', 1, 'USD', 'Dollar', '+246', '', 'en-IO', '1282588', '', 1, 0, 0, 0, 0, 0),
(90, 'SB', 'SLB', 'BP', 'Solomon Islands', 4, 'SBD', 'Dollar', '+677', '', 'en-SB,tpi', '2103350', '', 1, 0, 0, 0, 0, 0),
(92, 'VG', 'VGB', 'VI', 'British Virgin Islands', 6, 'USD', 'Dollar', '+1-284', '', 'en-VG', '3577718', '', 1, 0, 0, 0, 0, 0),
(96, 'BN', 'BRN', 'BX', 'Brunei', 1, 'BND', 'Dollar', '+673', '^([A-Z]{2}d{4})$', 'ms-BN,en-BN', '1820814', '', 1, 0, 0, 0, 0, 0),
(100, 'BG', 'BGR', 'BU', 'Bulgaria', 5, 'BGN', 'Lev', '+359', '^(d{4})$', 'bg,tr-BG', '732800', '', 1, 0, 0, 0, 0, 0),
(104, 'MM', 'MMR', 'BM', 'Myanmar', 1, 'MMK', 'Kyat', '+95', '^(d{5})$', 'my', '1327865', '', 1, 0, 0, 0, 0, 0),
(108, 'BI', 'BDI', 'BY', 'Burundi', 2, 'BIF', 'Franc', '+257', '', 'fr-BI,rn', '433561', '', 1, 0, 0, 0, 0, 0),
(112, 'BY', 'BLR', 'BO', 'Belarus', 5, 'BYR', 'Ruble', '+375', '^(d{6})$', 'be,ru', '630336', '', 1, 0, 0, 0, 0, 0),
(116, 'KH', 'KHM', 'CB', 'Cambodia', 1, 'KHR', 'Riels', '+855', '^(d{5})$', 'km,fr,en', '1831722', '', 1, 0, 0, 0, 0, 0),
(120, 'CM', 'CMR', 'CM', 'Cameroon', 2, 'XAF', 'Franc', '+237', '', 'en-CM,fr-CM', '2233387', '', 1, 0, 0, 0, 0, 0),
(124, 'CA', 'CAN', 'CA', 'Canada', 6, 'CAD', 'Dollar', '+1', '^([a-zA-Z]d[a-zA-Z]d[a-zA-Z]d)$', 'en-CA,fr-CA', '6251999', '', 1, 0, 0, 0, 0, 0),
(132, 'CV', 'CPV', 'CV', 'Cape Verde', 2, 'CVE', 'Escudo', '+238', '^(d{4})$', 'pt-CV', '3374766', '', 1, 0, 0, 0, 0, 0),
(136, 'KY', 'CYM', 'CJ', 'Cayman Islands', 6, 'KYD', 'Dollar', '+1-345', '', 'en-KY', '3580718', '', 1, 0, 0, 0, 0, 0),
(140, 'CF', 'CAF', 'CT', 'Central African Republic', 2, 'XAF', 'Franc', '+236', '', 'fr-CF,ln,kg', '239880', '', 1, 0, 0, 0, 0, 0),
(144, 'LK', 'LKA', 'CE', 'Sri Lanka', 1, 'LKR', 'Rupee', '+94', '^(d{5})$', 'si,ta,en', '1227603', '', 1, 0, 0, 0, 0, 0),
(148, 'TD', 'TCD', 'CD', 'Chad', 2, 'XAF', 'Franc', '+235', '', 'fr-TD,ar-TD,sre', '2434508', '', 1, 0, 0, 0, 0, 0),
(152, 'CL', 'CHL', 'CI', 'Chile', 7, 'CLP', 'Peso', '+56', '^(d{7})$', 'es-CL', '3895114', '', 1, 0, 0, 0, 0, 0),
(156, 'CN', 'CHN', 'CH', 'China', 1, 'CNY', 'Yuan Renminbi', '+86', '^(d{6})$', 'zh-CN,yue,wuu', '1814991', '', 1, 0, 0, 0, 0, 0),
(158, 'TW', 'TWN', 'TW', 'Taiwan', 1, 'TWD', 'Dollar', '+886', '^(d{5})$', 'zh-TW,zh,nan,hak', '1668284', '', 1, 0, 0, 0, 0, 0),
(162, 'CX', 'CXR', 'KT', 'Christmas Island', 1, 'AUD', 'Dollar', '+61', '^(d{4})$', 'en,zh,ms-CC', '2078138', '', 1, 0, 0, 0, 0, 0),
(166, 'CC', 'CCK', 'CK', 'Cocos Islands', 1, 'AUD', 'Dollar', '+61', '', 'ms-CC,en', '1547376', '', 1, 0, 0, 0, 0, 0),
(170, 'CO', 'COL', 'CO', 'Colombia', 7, 'COP', 'Peso', '+57', '', 'es-CO', '3686110', '', 1, 0, 0, 0, 0, 0),
(174, 'KM', 'COM', 'CN', 'Comoros', 2, 'KMF', 'Franc', '+269', '', 'ar,fr-KM', '921929', '', 1, 0, 0, 0, 0, 0),
(175, 'YT', 'MYT', 'MF', 'Mayotte', 2, 'EUR', 'Euro', '+269', '^(d{5})$', 'fr-YT', '1024031', '', 1, 0, 0, 0, 0, 0),
(178, 'CG', 'COG', 'CF', 'Republic of the Congo', 2, 'XAF', 'Franc', '+242', '', 'fr-CG,kg,ln-CG', '2260494', '', 1, 0, 0, 0, 0, 0),
(180, 'CD', 'COD', 'CG', 'Democratic Republic of the Congo', 2, 'CDF', 'Franc', '+243', '', 'fr-CD,ln,kg', '203312', '', 1, 0, 0, 0, 0, 0),
(184, 'CK', 'COK', 'CW', 'Cook Islands', 4, 'NZD', 'Dollar', '+682', '', 'en-CK,mi', '1899402', '', 1, 0, 0, 0, 0, 0),
(188, 'CR', 'CRI', 'CS', 'Costa Rica', 6, 'CRC', 'Colon', '+506', '^(d{4})$', 'es-CR,en', '3624060', '', 1, 0, 0, 0, 0, 0),
(191, 'HR', 'HRV', 'HR', 'Croatia', 5, 'HRK', 'Kuna', '+385', '^(?:HR)*(d{5})$', 'hr-HR,sr', '3202326', '', 1, 0, 0, 0, 0, 0),
(192, 'CU', 'CUB', 'CU', 'Cuba', 6, 'CUP', 'Peso', '+53', '^(?:CP)*(d{5})$', 'es-CU', '3562981', '', 1, 0, 0, 0, 0, 0),
(196, 'CY', 'CYP', 'CY', 'Cyprus', 5, 'EUR', 'Euro', '+357', '^(d{4})$', 'el-CY,tr-CY,en', '146669', '', 1, 0, 0, 0, 0, 0),
(203, 'CZ', 'CZE', 'EZ', 'Czech Republic', 5, 'CZK', 'Koruna', '+420', '^(d{5})$', 'cs,sk', '3077311', '', 1, 0, 0, 0, 0, 0),
(204, 'BJ', 'BEN', 'BN', 'Benin', 2, 'XOF', 'Franc', '+229', '', 'fr-BJ', '2395170', '', 1, 0, 0, 0, 0, 0),
(208, 'DK', 'DNK', 'DA', 'Denmark', 5, 'DKK', 'Krone', '+45', '^(d{4})$', 'da-DK,en,fo,de-DK', '2623032', '', 1, 0, 0, 0, 0, 0),
(212, 'DM', 'DMA', 'DO', 'Dominica', 6, 'XCD', 'Dollar', '+1-767', '', 'en-DM', '3575830', '', 1, 0, 0, 0, 0, 0),
(214, 'DO', 'DOM', 'DR', 'Dominican Republic', 6, 'DOP', 'Peso', '+1-809 and 1-829', '^(d{5})$', 'es-DO', '3508796', '', 1, 0, 0, 0, 0, 0),
(218, 'EC', 'ECU', 'EC', 'Ecuador', 7, 'USD', 'Dollar', '+593', '^([a-zA-Z]d{4}[a-zA-Z])$', 'es-EC', '3658394', '', 1, 0, 0, 0, 0, 0),
(222, 'SV', 'SLV', 'ES', 'El Salvador', 6, 'USD', 'Dollar', '+503', '^(?:CP)*(d{4})$', 'es-SV', '3585968', '', 1, 0, 0, 0, 0, 0),
(226, 'GQ', 'GNQ', 'EK', 'Equatorial Guinea', 2, 'XAF', 'Franc', '+240', '', 'es-GQ,fr', '2309096', '', 1, 0, 0, 0, 0, 0),
(231, 'ET', 'ETH', 'ET', 'Ethiopia', 2, 'ETB', 'Birr', '+251', '^(d{4})$', 'am,en-ET,om-ET,ti-ET,so-ET,sid', '337996', '', 1, 0, 0, 0, 0, 0),
(232, 'ER', 'ERI', 'ER', 'Eritrea', 2, 'ERN', 'Nakfa', '+291', '', 'aa-ER,ar,tig,kun,ti-ER', '338010', '', 1, 0, 0, 0, 0, 0),
(233, 'EE', 'EST', 'EN', 'Estonia', 5, 'EEK', 'Kroon', '+372', '^(d{5})$', 'et,ru', '453733', '', 1, 0, 0, 0, 0, 0),
(234, 'FO', 'FRO', 'FO', 'Faroe Islands', 5, 'DKK', 'Krone', '+298', '^(?:FO)*(d{3})$', 'fo,da-FO', '2622320', '', 1, 0, 0, 0, 0, 0),
(238, 'FK', 'FLK', 'FK', 'Falkland Islands', 7, 'FKP', 'Pound', '+500', '', 'en-FK', '3474414', '', 1, 0, 0, 0, 0, 0),
(239, 'GS', 'SGS', 'SX', 'South Georgia and the South Sandwich Islands', 3, 'GBP', 'Pound', '+', '', 'en', '3474415', '', 1, 0, 0, 0, 0, 0),
(242, 'FJ', 'FJI', 'FJ', 'Fiji', 4, 'FJD', 'Dollar', '+679', '', 'en-FJ,fj', '2205218', '', 1, 0, 0, 0, 0, 0),
(246, 'FI', 'FIN', 'FI', 'Finland', 5, 'EUR', 'Euro', '+358', '^(?:FI)*(d{5})$', 'fi-FI,sv-FI,smn', '660013', '', 1, 0, 0, 0, 0, 0),
(248, 'AX', 'ALA', '', 'Aland Islands', 5, 'EUR', 'Euro', '+358-18', '', 'sv-AX', '661882', '', 1, 0, 0, 0, 0, 0),
(250, 'FR', 'FRA', 'FR', 'France', 5, 'EUR', 'Euro', '+33', '^(d{5})$', 'fr-FR,frp,br,co,ca,eu', '3017382', '', 1, 0, 0, 0, 0, 0),
(254, 'GF', 'GUF', 'FG', 'French Guiana', 7, 'EUR', 'Euro', '+594', '^((97)|(98)3d{2})$', 'fr-GF', '3381670', '', 1, 0, 0, 0, 0, 0),
(258, 'PF', 'PYF', 'FP', 'French Polynesia', 4, 'XPF', 'Franc', '+689', '^((97)|(98)7d{2})$', 'fr-PF,ty', '4020092', '', 1, 0, 0, 0, 0, 0),
(260, 'TF', 'ATF', 'FS', 'French Southern Territories', 3, 'EUR', 'Euro  ', '+', '', 'fr', '1546748', '', 1, 0, 0, 0, 0, 0),
(262, 'DJ', 'DJI', 'DJ', 'Djibouti', 2, 'DJF', 'Franc', '+253', '', 'fr-DJ,ar,so-DJ,aa', '223816', '', 1, 0, 0, 0, 0, 0),
(266, 'GA', 'GAB', 'GB', 'Gabon', 2, 'XAF', 'Franc', '+241', '', 'fr-GA', '2400553', '', 1, 0, 0, 0, 0, 0),
(268, 'GE', 'GEO', 'GG', 'Georgia', 1, 'GEL', 'Lari', '+995', '^(d{4})$', 'ka,ru,hy,az', '614540', '', 1, 0, 0, 0, 0, 0),
(270, 'GM', 'GMB', 'GA', 'Gambia', 2, 'GMD', 'Dalasi', '+220', '', 'en-GM,mnk,wof,wo,ff', '2413451', '', 1, 0, 0, 0, 0, 0),
(275, 'PS', 'PSE', 'WE', 'Palestinian Territory', 1, 'ILS', 'Shekel', '+970', '', 'ar-PS', '6254930', '', 1, 0, 0, 0, 0, 0),
(276, 'DE', 'DEU', 'GM', 'Germany', 5, 'EUR', 'Euro', '+49', '^(d{5})$', 'de', '2921044', '', 1, 0, 0, 0, 0, 0),
(288, 'GH', 'GHA', 'GH', 'Ghana', 2, 'GHS', 'Cedi', '+233', '', 'en-GH,ak,ee,tw', '2300660', '', 1, 0, 0, 0, 0, 0),
(292, 'GI', 'GIB', 'GI', 'Gibraltar', 5, 'GIP', 'Pound', '+350', '', 'en-GI,es,it,pt', '2411586', '', 1, 0, 0, 0, 0, 0),
(296, 'KI', 'KIR', 'KR', 'Kiribati', 4, 'AUD', 'Dollar', '+686', '', 'en-KI,gil', '4030945', '', 1, 0, 0, 0, 0, 0),
(300, 'GR', 'GRC', 'GR', 'Greece', 5, 'EUR', 'Euro', '+30', '^(d{5})$', 'el-GR,en,fr', '390903', '', 1, 0, 0, 0, 0, 0),
(304, 'GL', 'GRL', 'GL', 'Greenland', 6, 'DKK', 'Krone', '+299', '^(d{4})$', 'kl,da-GL,en', '3425505', '', 1, 0, 0, 0, 0, 0),
(308, 'GD', 'GRD', 'GJ', 'Grenada', 6, 'XCD', 'Dollar', '+1-473', '', 'en-GD', '3580239', '', 1, 0, 0, 0, 0, 0),
(312, 'GP', 'GLP', 'GP', 'Guadeloupe', 6, 'EUR', 'Euro', '+590', '^((97)|(98)d{3})$', 'fr-GP', '3579143', '', 1, 0, 0, 0, 0, 0),
(316, 'GU', 'GUM', 'GQ', 'Guam', 4, 'USD', 'Dollar', '+1-671', '^(969d{2})$', 'en-GU,ch-GU', '4043988', '', 1, 0, 0, 0, 0, 0),
(320, 'GT', 'GTM', 'GT', 'Guatemala', 6, 'GTQ', 'Quetzal', '+502', '^(d{5})$', 'es-GT', '3595528', '', 1, 0, 0, 0, 0, 0),
(324, 'GN', 'GIN', 'GV', 'Guinea', 2, 'GNF', 'Franc', '+224', '', 'fr-GN', '2420477', '', 1, 0, 0, 0, 0, 0),
(328, 'GY', 'GUY', 'GY', 'Guyana', 7, 'GYD', 'Dollar', '+592', '', 'en-GY', '3378535', '', 1, 0, 0, 0, 0, 0),
(332, 'HT', 'HTI', 'HA', 'Haiti', 6, 'HTG', 'Gourde', '+509', '^(?:HT)*(d{4})$', 'ht,fr-HT', '3723988', '', 1, 0, 0, 0, 0, 0),
(334, 'HM', 'HMD', 'HM', 'Heard Island and McDonald Islands', 3, 'AUD', 'Dollar', '+ ', '', '', '1547314', '', 1, 0, 0, 0, 0, 0),
(336, 'VA', 'VAT', 'VT', 'Vatican', 5, 'EUR', 'Euro', '+379', '', 'la,it,fr', '3164670', '', 1, 0, 0, 0, 0, 0),
(340, 'HN', 'HND', 'HO', 'Honduras', 6, 'HNL', 'Lempira', '+504', '^([A-Z]{2}d{4})$', 'es-HN', '3608932', '', 1, 0, 0, 0, 0, 0),
(344, 'HK', 'HKG', 'HK', 'Hong Kong', 1, 'HKD', 'Dollar', '+852', '', 'zh-HK,yue,zh,en', '1819730', '', 1, 0, 0, 0, 0, 0),
(348, 'HU', 'HUN', 'HU', 'Hungary', 5, 'HUF', 'Forint', '+36', '^(d{4})$', 'hu-HU', '719819', '', 1, 0, 0, 0, 0, 0),
(352, 'IS', 'ISL', 'IC', 'Iceland', 5, 'ISK', 'Krona', '+354', '^(d{3})$', 'is,en,de,da,sv,no', '2629691', '', 1, 0, 0, 0, 0, 0),
(356, 'IN', 'IND', 'IN', 'India', 1, 'INR', 'Rupee', '+91', '^(d{6})$', 'en-IN,hi,bn,te,mr,ta,ur,gu,ml,kn,or,pa,as,ks,', '1269750', '', 1, 0, 0, 0, 0, 0),
(360, 'ID', 'IDN', 'ID', 'Indonesia', 1, 'IDR', 'Rupiah', '+62', '^(d{5})$', 'id,en,nl,jv', '1643084', '', 1, 0, 0, 0, 0, 0),
(364, 'IR', 'IRN', 'IR', 'Iran', 1, 'IRR', 'Rial', '+98', '^(d{10})$', 'fa-IR,ku', '130758', '', 1, 0, 0, 0, 0, 0),
(368, 'IQ', 'IRQ', 'IZ', 'Iraq', 1, 'IQD', 'Dinar', '+964', '^(d{5})$', 'ar-IQ,ku,hy', '99237', '', 1, 0, 0, 0, 0, 0),
(372, 'IE', 'IRL', 'EI', 'Ireland', 5, 'EUR', 'Euro', '+353', '', 'en-IE,ga-IE', '2963597', '', 1, 0, 0, 0, 0, 0),
(376, 'IL', 'ISR', 'IS', 'Israel', 1, 'ILS', 'Shekel', '+972', '^(d{5})$', 'he,ar-IL,en-IL,', '294640', '', 1, 0, 0, 0, 0, 0),
(380, 'IT', 'ITA', 'IT', 'Italy', 5, 'EUR', 'Euro', '+39', '^(d{5})$', 'it-IT,de-IT,fr-IT,sl', '3175395', '', 1, 0, 0, 0, 0, 0),
(384, 'CI', 'CIV', 'IV', 'Ivory Coast', 2, 'XOF', 'Franc', '+225', '', 'fr-CI', '2287781', '', 1, 0, 0, 0, 0, 0),
(388, 'JM', 'JAM', 'JM', 'Jamaica', 6, 'JMD', 'Dollar', '+1-876', '', 'en-JM', '3489940', '', 1, 0, 0, 0, 0, 0),
(392, 'JP', 'JPN', 'JA', 'Japan', 1, 'JPY', 'Yen', '+81', '^(d{7})$', 'ja', '1861060', '', 1, 0, 0, 0, 0, 0),
(398, 'KZ', 'KAZ', 'KZ', 'Kazakhstan', 1, 'KZT', 'Tenge', '+7', '^(d{6})$', 'kk,ru', '1522867', '', 1, 0, 0, 0, 0, 0),
(400, 'JO', 'JOR', 'JO', 'Jordan', 1, 'JOD', 'Dinar', '+962', '^(d{5})$', 'ar-JO,en', '248816', '', 1, 0, 0, 0, 0, 0),
(404, 'KE', 'KEN', 'KE', 'Kenya', 2, 'KES', 'Shilling', '+254', '^(d{5})$', 'en-KE,sw-KE', '192950', '', 1, 0, 0, 0, 0, 0),
(408, 'KP', 'PRK', 'KN', 'North Korea', 1, 'KPW', 'Won', '+850', '^(d{6})$', 'ko-KP', '1873107', '', 1, 0, 0, 0, 0, 0),
(410, 'KR', 'KOR', 'KS', 'South Korea', 1, 'KRW', 'Won', '+82', '^(?:SEOUL)*(d{6})$', 'ko-KR,en', '1835841', '', 1, 0, 0, 0, 0, 0),
(414, 'KW', 'KWT', 'KU', 'Kuwait', 1, 'KWD', 'Dinar', '+965', '^(d{5})$', 'ar-KW,en', '285570', '', 1, 0, 0, 0, 0, 0),
(417, 'KG', 'KGZ', 'KG', 'Kyrgyzstan', 1, 'KGS', 'Som', '+996', '^(d{6})$', 'ky,uz,ru', '1527747', '', 1, 0, 0, 0, 0, 0),
(418, 'LA', 'LAO', 'LA', 'Laos', 1, 'LAK', 'Kip', '+856', '^(d{5})$', 'lo,fr,en', '1655842', '', 1, 0, 0, 0, 0, 0),
(422, 'LB', 'LBN', 'LE', 'Lebanon', 1, 'LBP', 'Pound', '+961', '^(d{4}(d{4})?)$', 'ar-LB,fr-LB,en,hy', '272103', '', 1, 0, 0, 0, 0, 0),
(426, 'LS', 'LSO', 'LT', 'Lesotho', 2, 'LSL', 'Loti', '+266', '^(d{3})$', 'en-LS,st,zu,xh', '932692', '', 1, 0, 0, 0, 0, 0),
(428, 'LV', 'LVA', 'LG', 'Latvia', 5, 'LVL', 'Lat', '+371', '^(?:LV)*(d{4})$', 'lv,ru,lt', '458258', '', 1, 0, 0, 0, 0, 0),
(430, 'LR', 'LBR', 'LI', 'Liberia', 2, 'LRD', 'Dollar', '+231', '^(d{4})$', 'en-LR', '2275384', '', 1, 0, 0, 0, 0, 0),
(434, 'LY', 'LBY', 'LY', 'Libya', 2, 'LYD', 'Dinar', '+218', '', 'ar-LY,it,en', '2215636', '', 1, 0, 0, 0, 0, 0),
(438, 'LI', 'LIE', 'LS', 'Liechtenstein', 5, 'CHF', 'Franc', '+423', '^(d{4})$', 'de-LI', '3042058', '', 1, 0, 0, 0, 0, 0),
(440, 'LT', 'LTU', 'LH', 'Lithuania', 5, 'LTL', 'Litas', '+370', '^(?:LT)*(d{5})$', 'lt,ru,pl', '597427', '', 1, 0, 0, 0, 0, 0),
(442, 'LU', 'LUX', 'LU', 'Luxembourg', 5, 'EUR', 'Euro', '+352', '^(d{4})$', 'lb,de-LU,fr-LU', '2960313', '', 1, 0, 0, 0, 0, 0),
(446, 'MO', 'MAC', 'MC', 'Macao', 1, 'MOP', 'Pataca', '+853', '', 'zh,zh-MO', '1821275', '', 1, 0, 0, 0, 0, 0),
(450, 'MG', 'MDG', 'MA', 'Madagascar', 2, 'MGA', 'Ariary', '+261', '^(d{3})$', 'fr-MG,mg', '1062947', '', 1, 0, 0, 0, 0, 0),
(454, 'MW', 'MWI', 'MI', 'Malawi', 2, 'MWK', 'Kwacha', '+265', '', 'ny,yao,tum,swk', '927384', '', 1, 0, 0, 0, 0, 0),
(458, 'MY', 'MYS', 'MY', 'Malaysia', 1, 'MYR', 'Ringgit', '+60', '^(d{5})$', 'ms-MY,en,zh,ta,te,ml,pa,th', '1733045', '', 1, 0, 0, 0, 0, 0),
(462, 'MV', 'MDV', 'MV', 'Maldives', 1, 'MVR', 'Rufiyaa', '+960', '^(d{5})$', 'dv,en', '1282028', '', 1, 0, 0, 0, 0, 0),
(466, 'ML', 'MLI', 'ML', 'Mali', 2, 'XOF', 'Franc', '+223', '', 'fr-ML,bm', '2453866', '', 1, 0, 0, 0, 0, 0),
(470, 'MT', 'MLT', 'MT', 'Malta', 5, 'EUR', 'Euro', '+356', '^([A-Z]{3}d{2}d?)$', 'mt,en-MT', '2562770', '', 1, 0, 0, 0, 0, 0),
(474, 'MQ', 'MTQ', 'MB', 'Martinique', 6, 'EUR', 'Euro', '+596', '^(d{5})$', 'fr-MQ', '3570311', '', 1, 0, 0, 0, 0, 0),
(478, 'MR', 'MRT', 'MR', 'Mauritania', 2, 'MRO', 'Ouguiya', '+222', '', 'ar-MR,fuc,snk,fr,mey,wo', '2378080', '', 1, 0, 0, 0, 0, 0),
(480, 'MU', 'MUS', 'MP', 'Mauritius', 2, 'MUR', 'Rupee', '+230', '', 'en-MU,bho,fr', '934292', '', 1, 0, 0, 0, 0, 0),
(484, 'MX', 'MEX', 'MX', 'Mexico', 6, 'MXN', 'Peso', '+52', '^(d{5})$', 'es-MX', '3996063', '', 1, 0, 0, 0, 0, 0),
(492, 'MC', 'MCO', 'MN', 'Monaco', 5, 'EUR', 'Euro', '+377', '^(d{5})$', 'fr-MC,en,it', '2993457', '', 1, 0, 0, 0, 0, 0),
(496, 'MN', 'MNG', 'MG', 'Mongolia', 1, 'MNT', 'Tugrik', '+976', '^(d{6})$', 'mn,ru', '2029969', '', 1, 0, 0, 0, 0, 0),
(498, 'MD', 'MDA', 'MD', 'Moldova', 5, 'MDL', 'Leu', '+373', '^(?:MD)*(d{4})$', 'ro,ru,gag,tr', '617790', '', 1, 0, 0, 0, 0, 0),
(499, 'ME', 'MNE', 'MJ', 'Montenegro', 5, 'EUR', 'Euro', '+381', '^(d{5})$', 'sr,hu,bs,sq,hr,rom', '3194884', '', 1, 0, 0, 0, 0, 0),
(500, 'MS', 'MSR', 'MH', 'Montserrat', 6, 'XCD', 'Dollar', '+1-664', '', 'en-MS', '3578097', '', 1, 0, 0, 0, 0, 0),
(504, 'MA', 'MAR', 'MO', 'Morocco', 2, 'MAD', 'Dirham', '+212', '^(d{5})$', 'ar-MA,fr', '2542007', '', 1, 0, 0, 0, 0, 0),
(508, 'MZ', 'MOZ', 'MZ', 'Mozambique', 2, 'MZN', 'Meticail', '+258', '^(d{4})$', 'pt-MZ,vmw', '1036973', '', 1, 0, 0, 0, 0, 0),
(512, 'OM', 'OMN', 'MU', 'Oman', 1, 'OMR', 'Rial', '+968', '^(d{3})$', 'ar-OM,en,bal,ur', '286963', '', 1, 0, 0, 0, 0, 0),
(516, 'NA', 'NAM', 'WA', 'Namibia', 2, 'NAD', 'Dollar', '+264', '', 'en-NA,af,de,hz,naq', '3355338', '', 1, 0, 0, 0, 0, 0),
(520, 'NR', 'NRU', 'NR', 'Nauru', 4, 'AUD', 'Dollar', '+674', '', 'na,en-NR', '2110425', '', 1, 0, 0, 0, 0, 0),
(524, 'NP', 'NPL', 'NP', 'Nepal', 1, 'NPR', 'Rupee', '+977', '^(d{5})$', 'ne,en', '1282988', '', 1, 0, 0, 0, 0, 0),
(528, 'NL', 'NLD', 'NL', 'Netherlands', 5, 'EUR', 'Euro', '+31', '^(d{4}[A-Z]{2})$', 'nl-NL,fy-NL', '2750405', '', 1, 0, 0, 0, 0, 0),
(530, 'AN', 'ANT', 'NT', 'Netherlands Antilles', 6, 'ANG', 'Guilder', '+599', '', 'nl-AN,en,es', '3513447', '', 1, 0, 0, 0, 0, 0),
(533, 'AW', 'ABW', 'AA', 'Aruba', 6, 'AWG', 'Guilder', '+297', '', 'nl-AW,es,en', '3577279', '', 1, 0, 0, 0, 0, 0),
(540, 'NC', 'NCL', 'NC', 'New Caledonia', 4, 'XPF', 'Franc', '+687', '^(d{5})$', 'fr-NC', '2139685', '', 1, 0, 0, 0, 0, 0),
(548, 'VU', 'VUT', 'NH', 'Vanuatu', 4, 'VUV', 'Vatu', '+678', '', 'bi,en-VU,fr-VU', '2134431', '', 1, 0, 0, 0, 0, 0),
(554, 'NZ', 'NZL', 'NZ', 'New Zealand', 4, 'NZD', 'Dollar', '+64', '^(d{4})$', 'en-NZ,mi', '2186224', '', 1, 0, 0, 0, 0, 0),
(558, 'NI', 'NIC', 'NU', 'Nicaragua', 6, 'NIO', 'Cordoba', '+505', '^(d{7})$', 'es-NI,en', '3617476', '', 1, 0, 0, 0, 0, 0),
(562, 'NE', 'NER', 'NG', 'Niger', 2, 'XOF', 'Franc', '+227', '^(d{4})$', 'fr-NE,ha,kr,dje', '2440476', '', 1, 0, 0, 0, 0, 0),
(566, 'NG', 'NGA', 'NI', 'Nigeria', 2, 'NGN', 'Naira', '+234', '^(d{6})$', 'en-NG,ha,yo,ig,ff', '2328926', '', 1, 0, 0, 0, 0, 0),
(570, 'NU', 'NIU', 'NE', 'Niue', 4, 'NZD', 'Dollar', '+683', '', 'niu,en-NU', '4036232', '', 1, 0, 0, 0, 0, 0),
(574, 'NF', 'NFK', 'NF', 'Norfolk Island', 4, 'AUD', 'Dollar', '+672', '', 'en-NF', '2155115', '', 1, 0, 0, 0, 0, 0),
(578, 'NO', 'NOR', 'NO', 'Norway', 5, 'NOK', 'Krone', '+47', '^(d{4})$', 'no,nb,nn', '3144096', '', 1, 0, 0, 0, 0, 0),
(580, 'MP', 'MNP', 'CQ', 'Northern Mariana Islands', 4, 'USD', 'Dollar', '+1-670', '', 'fil,tl,zh,ch-MP,en-MP', '4041467', '', 1, 0, 0, 0, 0, 0),
(581, 'UM', 'UMI', '', 'United States Minor Outlying Islands', 4, 'USD', 'Dollar ', '+', '', 'en-UM', '5854968', '', 1, 0, 0, 0, 0, 0),
(583, 'FM', 'FSM', 'FM', 'Micronesia', 4, 'USD', 'Dollar', '+691', '^(d{5})$', 'en-FM,chk,pon,yap,kos,uli,woe,nkr,kpg', '2081918', '', 1, 0, 0, 0, 0, 0),
(584, 'MH', 'MHL', 'RM', 'Marshall Islands', 4, 'USD', 'Dollar', '+692', '', 'mh,en-MH', '2080185', '', 1, 0, 0, 0, 0, 0),
(585, 'PW', 'PLW', 'PS', 'Palau', 4, 'USD', 'Dollar', '+680', '^(96940)$', 'pau,sov,en-PW,tox,ja,fil,zh', '1559582', '', 1, 0, 0, 0, 0, 0),
(586, 'PK', 'PAK', 'PK', 'Pakistan', 1, 'PKR', 'Rupee', '+92', '^(d{5})$', 'ur-PK,en-PK,pa,sd,ps,brh', '1168579', '', 1, 0, 0, 0, 0, 0),
(591, 'PA', 'PAN', 'PM', 'Panama', 6, 'PAB', 'Balboa', '+507', '', 'es-PA,en', '3703430', '', 1, 0, 0, 0, 0, 0),
(598, 'PG', 'PNG', 'PP', 'Papua New Guinea', 4, 'PGK', 'Kina', '+675', '^(d{3})$', 'en-PG,ho,meu,tpi', '2088628', '', 1, 0, 0, 0, 0, 0),
(600, 'PY', 'PRY', 'PA', 'Paraguay', 7, 'PYG', 'Guarani', '+595', '^(d{4})$', 'es-PY,gn', '3437598', '', 1, 0, 0, 0, 0, 0),
(604, 'PE', 'PER', 'PE', 'Peru', 7, 'PEN', 'Sol', '+51', '', 'es-PE,qu,ay', '3932488', '', 1, 0, 0, 0, 0, 0),
(608, 'PH', 'PHL', 'RP', 'Philippines', 1, 'PHP', 'Peso', '+63', '^(d{4})$', 'tl,en-PH,fil', '1694008', '', 1, 0, 0, 0, 0, 0),
(612, 'PN', 'PCN', 'PC', 'Pitcairn', 4, 'NZD', 'Dollar', '+', '', 'en-PN', '4030699', '', 1, 0, 0, 0, 0, 0),
(616, 'PL', 'POL', 'PL', 'Poland', 5, 'PLN', 'Zloty', '+48', '^(d{5})$', 'pl', '798544', '', 1, 0, 0, 0, 0, 0),
(620, 'PT', 'PRT', 'PO', 'Portugal', 5, 'EUR', 'Euro', '+351', '^(d{7})$', 'pt-PT,mwl', '2264397', '', 1, 0, 0, 0, 0, 0),
(624, 'GW', 'GNB', 'PU', 'Guinea-Bissau', 2, 'XOF', 'Franc', '+245', '^(d{4})$', 'pt-GW,pov', '2372248', '', 1, 0, 0, 0, 0, 0),
(626, 'TL', 'TLS', 'TT', 'East Timor', 4, 'USD', 'Dollar', '+670', '', 'tet,pt-TL,id,en', '1966436', '', 1, 0, 0, 0, 0, 0),
(630, 'PR', 'PRI', 'RQ', 'Puerto Rico', 6, 'USD', 'Dollar', '+1-787 and 1-939', '^(d{9})$', 'en-PR,es-PR', '4566966', '', 1, 0, 0, 0, 0, 0),
(634, 'QA', 'QAT', 'QA', 'Qatar', 1, 'QAR', 'Rial', '+974', '', 'ar-QA,es', '289688', '', 1, 0, 0, 0, 0, 0),
(638, 'RE', 'REU', 'RE', 'Reunion', 2, 'EUR', 'Euro', '+262', '^((97)|(98)(4|7|8)d{2})$', 'fr-RE', '935317', '', 1, 0, 0, 0, 0, 0),
(642, 'RO', 'ROU', 'RO', 'Romania', 5, 'RON', 'Leu', '+40', '^(d{6})$', 'ro,hu,rom', '798549', '', 1, 0, 0, 0, 0, 0),
(643, 'RU', 'RUS', 'RS', 'Russia', 5, 'RUB', 'Ruble', '+7', '^(d{6})$', 'ru-RU', '2017370', '', 1, 0, 0, 0, 0, 0),
(646, 'RW', 'RWA', 'RW', 'Rwanda', 2, 'RWF', 'Franc', '+250', '', 'rw,en-RW,fr-RW,sw', '49518', '', 1, 0, 0, 0, 0, 0),
(652, 'BL', 'BLM', 'TB', 'Saint Barthélemy', 6, 'EUR', 'Euro', '+590', '', 'fr', '3578476', '', 1, 0, 0, 0, 0, 0),
(654, 'SH', 'SHN', 'SH', 'Saint Helena', 2, 'SHP', 'Pound', '+290', '^(STHL1ZZ)$', 'en-SH', '3370751', '', 1, 0, 0, 0, 0, 0),
(659, 'KN', 'KNA', 'SC', 'Saint Kitts and Nevis', 6, 'XCD', 'Dollar', '+1-869', '', 'en-KN', '3575174', '', 1, 0, 0, 0, 0, 0),
(660, 'AI', 'AIA', 'AV', 'Anguilla', 6, 'XCD', 'Dollar', '+1-264', '', 'en-AI', '3573511', '', 1, 0, 0, 0, 0, 0),
(662, 'LC', 'LCA', 'ST', 'Saint Lucia', 6, 'XCD', 'Dollar', '+1-758', '', 'en-LC', '3576468', '', 1, 0, 0, 0, 0, 0),
(663, 'MF', 'MAF', 'RN', 'Saint Martin', 6, 'EUR', 'Euro', '+590', '', 'fr', '3578421', '', 1, 0, 0, 0, 0, 0),
(666, 'PM', 'SPM', 'SB', 'Saint Pierre and Miquelon', 6, 'EUR', 'Euro', '+508', '^(97500)$', 'fr-PM', '3424932', '', 1, 0, 0, 0, 0, 0),
(670, 'VC', 'VCT', 'VC', 'Saint Vincent and the Grenadines', 6, 'XCD', 'Dollar', '+1-784', '', 'en-VC,fr', '3577815', '', 1, 0, 0, 0, 0, 0),
(674, 'SM', 'SMR', 'SM', 'San Marino', 5, 'EUR', 'Euro', '+378', '^(4789d)$', 'it-SM', '3168068', '', 1, 0, 0, 0, 0, 0),
(678, 'ST', 'STP', 'TP', 'Sao Tome and Principe', 2, 'STD', 'Dobra', '+239', '', 'pt-ST', '2410758', '', 1, 0, 0, 0, 0, 0),
(682, 'SA', 'SAU', 'SA', 'Saudi Arabia', 1, 'SAR', 'Rial', '+966', '^(d{5})$', 'ar-SA', '102358', '', 1, 0, 0, 0, 0, 0),
(686, 'SN', 'SEN', 'SG', 'Senegal', 2, 'XOF', 'Franc', '+221', '^(d{5})$', 'fr-SN,wo,fuc,mnk', '2245662', '', 1, 0, 0, 0, 0, 0),
(688, 'RS', 'SRB', 'RB', 'Serbia', 5, 'RSD', 'Dinar', '+381', '^(d{6})$', 'sr,hu,bs,rom', '6290252', '', 1, 0, 0, 0, 0, 0),
(690, 'SC', 'SYC', 'SE', 'Seychelles', 2, 'SCR', 'Rupee', '+248', '', 'en-SC,fr-SC', '241170', '', 1, 0, 0, 0, 0, 0),
(694, 'SL', 'SLE', 'SL', 'Sierra Leone', 2, 'SLL', 'Leone', '+232', '', 'en-SL,men,tem', '2403846', '', 1, 0, 0, 0, 0, 0),
(702, 'SG', 'SGP', 'SN', 'Singapore', 1, 'SGD', 'Dollar', '+65', '^(d{6})$', 'cmn,en-SG,ms-SG,ta-SG,zh-SG', '1880251', '', 1, 0, 0, 0, 0, 0),
(703, 'SK', 'SVK', 'LO', 'Slovakia', 5, 'EUR', 'Euro', '+421', '^(d{5})$', 'sk,hu', '3057568', '', 1, 0, 0, 0, 0, 0),
(704, 'VN', 'VNM', 'VM', 'Vietnam', 1, 'VND', 'Dong', '+84', '^(d{6})$', 'vi,en,fr,zh,km', '1562822', '', 1, 0, 0, 0, 0, 0),
(705, 'SI', 'SVN', 'SI', 'Slovenia', 5, 'EUR', 'Euro', '+386', '^(?:SI)*(d{4})$', 'sl,sh', '3190538', '', 1, 0, 0, 0, 0, 0),
(706, 'SO', 'SOM', 'SO', 'Somalia', 2, 'SOS', 'Shilling', '+252', '^([A-Z]{2}d{5})$', 'so-SO,ar-SO,it,en-SO', '51537', '', 1, 0, 0, 0, 0, 0),
(710, 'ZA', 'ZAF', 'SF', 'South Africa', 2, 'ZAR', 'Rand', '+27', '^(d{4})$', 'zu,xh,af,nso,en-ZA,tn,st,ts', '953987', '', 1, 0, 0, 0, 0, 0),
(716, 'ZW', 'ZWE', 'ZI', 'Zimbabwe', 2, 'ZWL', 'Dollar', '+263', '', 'en-ZW,sn,nr,nd', '878675', '', 1, 0, 0, 0, 0, 0),
(724, 'ES', 'ESP', 'SP', 'Spain', 5, 'EUR', 'Euro', '+34', '^(d{5})$', 'es-ES,ca,gl,eu', '2510769', '', 1, 0, 0, 0, 0, 0),
(732, 'EH', 'ESH', 'WI', 'Western Sahara', 2, 'MAD', 'Dirham', '+212', '', 'ar,mey', '2461445', '', 1, 0, 0, 0, 0, 0),
(736, 'SD', 'SDN', 'SU', 'Sudan', 2, 'SDG', 'Dinar', '+249', '^(d{5})$', 'ar-SD,en,fia', '366755', '', 1, 0, 0, 0, 0, 0),
(740, 'SR', 'SUR', 'NS', 'Suriname', 7, 'SRD', 'Dollar', '+597', '', 'nl-SR,en,srn,hns,jv', '3382998', '', 1, 0, 0, 0, 0, 0),
(744, 'SJ', 'SJM', 'SV', 'Svalbard and Jan Mayen', 5, 'NOK', 'Krone', '+47', '', 'no,ru', '607072', '', 1, 0, 0, 0, 0, 0),
(748, 'SZ', 'SWZ', 'WZ', 'Swaziland', 2, 'SZL', 'Lilangeni', '+268', '^([A-Z]d{3})$', 'en-SZ,ss-SZ', '934841', '', 1, 0, 0, 0, 0, 0),
(752, 'SE', 'SWE', 'SW', 'Sweden', 5, 'SEK', 'Krona', '+46', '^(?:SE)*(d{5})$', 'sv-SE,se,sma,fi-SE', '2661886', '', 1, 0, 0, 0, 0, 0),
(756, 'CH', 'CHE', 'SZ', 'Switzerland', 5, 'CHF', 'Franc', '+41', '^(d{4})$', 'de-CH,fr-CH,it-CH,rm', '2658434', '', 1, 0, 0, 0, 0, 0),
(760, 'SY', 'SYR', 'SY', 'Syria', 1, 'SYP', 'Pound', '+963', '', 'ar-SY,ku,hy,arc,fr,en', '163843', '', 1, 0, 0, 0, 0, 0),
(762, 'TJ', 'TJK', 'TI', 'Tajikistan', 1, 'TJS', 'Somoni', '+992', '^(d{6})$', 'tg,ru', '1220409', '', 1, 0, 0, 0, 0, 0),
(764, 'TH', 'THA', 'TH', 'Thailand', 1, 'THB', 'Baht', '+66', '^(d{5})$', 'th,en', '1605651', '', 1, 0, 0, 0, 0, 0),
(768, 'TG', 'TGO', 'TO', 'Togo', 2, 'XOF', 'Franc', '+228', '', 'fr-TG,ee,hna,kbp,dag,ha', '2363686', '', 1, 0, 0, 0, 0, 0),
(772, 'TK', 'TKL', 'TL', 'Tokelau', 4, 'NZD', 'Dollar', '+690', '', 'tkl,en-TK', '4031074', '', 1, 0, 0, 0, 0, 0),
(776, 'TO', 'TON', 'TN', 'Tonga', 4, 'TOP', 'Pa''anga', '+676', '', 'to,en-TO', '4032283', '', 1, 0, 0, 0, 0, 0),
(780, 'TT', 'TTO', 'TD', 'Trinidad and Tobago', 6, 'TTD', 'Dollar', '+1-868', '', 'en-TT,hns,fr,es,zh', '3573591', '', 1, 0, 0, 0, 0, 0),
(784, 'AE', 'ARE', 'AE', 'United Arab Emirates', 1, 'AED', 'Dirham', '+971', '', 'ar-AE,fa,en,hi,ur', '290557', '', 1, 0, 0, 0, 0, 0),
(788, 'TN', 'TUN', 'TS', 'Tunisia', 2, 'TND', 'Dinar', '+216', '^(d{4})$', 'ar-TN,fr', '2464461', '', 1, 0, 0, 0, 0, 0),
(792, 'TR', 'TUR', 'TU', 'Turkey', 1, 'TRY', 'Lira', '+90', '^(d{5})$', 'tr-TR,ku,diq,az,av', '298795', '', 1, 0, 0, 0, 0, 0),
(795, 'TM', 'TKM', 'TX', 'Turkmenistan', 1, 'TMT', 'Manat', '+993', '^(d{6})$', 'tk,ru,uz', '1218197', '', 1, 0, 0, 0, 0, 0),
(796, 'TC', 'TCA', 'TK', 'Turks and Caicos Islands', 6, 'USD', 'Dollar', '+1-649', '^(TKCA 1ZZ)$', 'en-TC', '3576916', '', 1, 0, 0, 0, 0, 0),
(798, 'TV', 'TUV', 'TV', 'Tuvalu', 4, 'AUD', 'Dollar', '+688', '', 'tvl,en,sm,gil', '2110297', '', 1, 0, 0, 0, 0, 0),
(800, 'UG', 'UGA', 'UG', 'Uganda', 2, 'UGX', 'Shilling', '+256', '', 'en-UG,lg,sw,ar', '226074', '', 1, 0, 0, 0, 0, 0),
(804, 'UA', 'UKR', 'UP', 'Ukraine', 5, 'UAH', 'Hryvnia', '+380', '^(d{5})$', 'uk,ru-UA,rom,pl,hu', '690791', '', 1, 0, 0, 0, 0, 0),
(807, 'MK', 'MKD', 'MK', 'Macedonia', 5, 'MKD', 'Denar', '+389', '^(d{4})$', 'mk,sq,tr,rmm,sr', '718075', '', 1, 0, 0, 0, 0, 0),
(818, 'EG', 'EGY', 'EG', 'Egypt', 2, 'EGP', 'Pound', '+20', '^(d{5})$', 'ar-EG,en,fr', '357994', '', 1, 0, 0, 0, 0, 0),
(826, 'GB', 'GBR', 'UK', 'United Kingdom', 5, 'GBP', 'Pound', '+44', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A', 'en-GB,cy-GB,gd', '2635167', '', 1, 0, 0, 0, 0, 0),
(831, 'GG', 'GGY', 'GK', 'Guernsey', 5, 'GBP', 'Pound', '+44-1481', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A', 'en,fr', '3042362', '', 1, 0, 0, 0, 0, 0),
(832, 'JE', 'JEY', 'JE', 'Jersey', 5, 'GBP', 'Pound', '+44-1534', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A', 'en,pt', '3042142', '', 1, 0, 0, 0, 0, 0),
(833, 'IM', 'IMN', 'IM', 'Isle of Man', 5, 'GBP', 'Pound', '+44-1624', '^(([A-Z]d{2}[A-Z]{2})|([A-Z]d{3}[A-Z]{2})|([A', 'en,gv', '3042225', '', 1, 0, 0, 0, 0, 0),
(834, 'TZ', 'TZA', 'TZ', 'Tanzania', 2, 'TZS', 'Shilling', '+255', '', 'sw-TZ,en,ar', '149590', '', 1, 0, 0, 0, 0, 0),
(840, 'US', 'USA', 'US', 'United States', 6, 'USD', 'Dollar', '+1', '^(d{9})$', 'en-US,es-US,haw', '6252001', '', 1, 0, 0, 0, 0, 0),
(850, 'VI', 'VIR', 'VQ', 'U.S. Virgin Islands', 6, 'USD', 'Dollar', '+1-340', '', 'en-VI', '4796775', '', 1, 0, 0, 0, 0, 0),
(854, 'BF', 'BFA', 'UV', 'Burkina Faso', 2, 'XOF', 'Franc', '+226', '', 'fr-BF', '2361809', '', 1, 0, 0, 0, 0, 0),
(855, 'XK', 'XKX', 'KV', 'Kosovo', 5, 'EUR', 'Euro', '+', '', 'sq,sr', '831053', '', 1, 0, 0, 0, 0, 0),
(858, 'UY', 'URY', 'UY', 'Uruguay', 7, 'UYU', 'Peso', '+598', '^(d{5})$', 'es-UY', '3439705', '', 1, 0, 0, 0, 0, 0),
(860, 'UZ', 'UZB', 'UZ', 'Uzbekistan', 1, 'UZS', 'Som', '+998', '^(d{6})$', 'uz,ru,tg', '1512440', '', 1, 0, 0, 0, 0, 0),
(862, 'VE', 'VEN', 'VE', 'Venezuela', 7, 'VEF', 'Bolivar', '+58', '^(d{4})$', 'es-VE', '3625428', '', 1, 0, 0, 0, 0, 0),
(876, 'WF', 'WLF', 'WF', 'Wallis and Futuna', 4, 'XPF', 'Franc', '+681', '^(986d{2})$', 'wls,fud,fr-WF', '4034749', '', 1, 0, 0, 0, 0, 0),
(882, 'WS', 'WSM', 'WS', 'Samoa', 4, 'WST', 'Tala', '+685', '', 'sm,en-WS', '4034894', '', 1, 0, 0, 0, 0, 0),
(887, 'YE', 'YEM', 'YM', 'Yemen', 1, 'YER', 'Rial', '+967', '', 'ar-YE', '69543', '', 1, 0, 0, 0, 0, 0),
(891, 'CS', 'SCG', 'YI', 'Serbia and Montenegro', 5, 'RSD', 'Dinar', '+381', '^(d{5})$', 'cu,hu,sq,sr', '863038', '', 1, 0, 0, 0, 0, 0),
(894, 'ZM', 'ZMB', 'ZA', 'Zambia', 2, 'ZMK', 'Kwacha', '+260', '^(d{5})$', 'en-ZM,bem,loz,lun,lue,ny,toi', '895949', '', 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE IF NOT EXISTS `designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `name`, `status`, `is_deleted`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(1, 'Assistant Professor', 1, 0, 1440863431, 1, 1440863431, 1),
(2, 'Associate Professor', 1, 0, 1440863448, 1, 1440863448, 1),
(3, 'Professor', 1, 0, 1440863456, 1, 1440863456, 1),
(4, 'Independent Researcher', 1, 0, 1440863470, 1, 1440863470, 1),
(5, 'Industrial Person', 1, 0, 1440863489, 1, 1440863489, 1),
(6, 'Research Scholar', 1, 0, 1440863502, 1, 1440863502, 1),
(7, 'Other', 1, 0, 1440863510, 1, 1440863510, 1);

-- --------------------------------------------------------

--
-- Table structure for table `editorial_board`
--

CREATE TABLE IF NOT EXISTS `editorial_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `institute_name` varchar(150) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `editorial_board`
--

INSERT INTO `editorial_board` (`id`, `full_name`, `qualification`, `designation`, `email`, `phone`, `institute_name`, `country`, `state`, `cv`, `status`, `priority`, `created_dt`, `created_by`, `updated_dt`, `updated_by`, `is_deleted`) VALUES
(1, 'Pritesh Khetani', 'Phd Completed', 'Sr. Software Engineer', 'pritesh@mailcatch.com', '9662795199', 'Noble Eng.', 'India', 'Gujarat', '1440939649_milan.doc', 1, 1, 1440871477, 1, 1441731245, 1, 0),
(2, 'Dharshan Patel', 'Phd Persuing', 'Sr. Civil Engineer', 'dharshan@mailcatch.com', '975643210', 'LD engineering', 'India', 'Gujarat', '1441731340_DhavalDobariya-2.docx', 1, 1, 1441731340, 1, 1441731340, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `formatter`
--

CREATE TABLE IF NOT EXISTS `formatter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `formatter`
--

INSERT INTO `formatter` (`id`, `name`, `email`, `status`, `is_deleted`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(1, 'Formatter One', 'formatter1@grdjournals.com', 1, 0, 1442123614, 1, 1442123614, 1),
(2, 'Formatter Two', 'formatter2@grdjournals.com', 1, 0, 1442123627, 1, 1442123627, 1);

-- --------------------------------------------------------

--
-- Table structure for table `group_rights`
--

CREATE TABLE IF NOT EXISTS `group_rights` (
  `group_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_master`
--

CREATE TABLE IF NOT EXISTS `menu_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `menu_title` varchar(128) NOT NULL,
  `page_url` varchar(128) NOT NULL,
  `module_id` int(11) NOT NULL DEFAULT '0',
  `show_in_menu` int(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL,
  `menu_icon` varchar(50) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=139 ;

--
-- Dumping data for table `menu_master`
--

INSERT INTO `menu_master` (`id`, `parent_id`, `menu_title`, `page_url`, `module_id`, `show_in_menu`, `sort_order`, `menu_icon`, `is_deleted`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(93, 0, 'Dashboard', 'dashboard/index', 0, 1, 0, 'fa fa-dashboard ', 0, 1438732800, 1, 0, 0),
(94, 0, 'CMS', 'cms/index', 0, 1, 0, 'fa fa-th-large', 0, 1438732800, 1, 0, 0),
(95, 0, 'Masters', 'masters/index', 0, 1, 0, 'fa fa-cog', 0, 1440115200, 1, 0, 0),
(96, 95, 'Article Types', 'articletype/index', 0, 1, 0, '', 0, 1440115200, 1, 0, 0),
(97, 95, 'Branches', 'branch/index', 0, 1, 0, '', 0, 1440115200, 1, 0, 0),
(98, 0, 'Update Page', 'cms/update', 0, 0, 0, '', 0, 1440268200, 1, 1440268200, 1),
(99, 0, 'Articles', 'article/index', 0, 1, 0, 'fa fa-newspaper-o', 0, 1440268200, 1, 0, 0),
(100, 0, 'Create Article', 'article/create', 0, 0, 0, '', 0, 1440268200, 1, 0, 0),
(101, 0, 'View Article', 'article/view', 0, 0, 0, '', 0, 1440268200, 1, 0, 0),
(102, 0, 'Update Article', 'article/update', 0, 0, 0, '', 0, 1440268200, 1, 0, 0),
(103, 0, 'Reviewer', 'editorialboard/index', 0, 1, 0, 'fa fa-slideshare', 0, 1440786600, 1, 1440786600, 1),
(104, 0, 'Create Reviewer', 'editorialboard/create', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(105, 0, 'Update Reviewer', 'editorialboard/update', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(106, 0, 'Delete Reviewer', 'editorialboard/delete', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(107, 95, 'Qualifications', 'qualification/index', 0, 1, 0, '', 0, 1440786600, 1, 0, 0),
(108, 107, 'Create Qualification', 'qualification/create', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(109, 107, 'Update Qualification', 'qualification/update', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(110, 107, 'Delete Qualification', 'qualification/delete', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(111, 95, 'Designations', 'designation/index', 0, 1, 0, '', 0, 1440786600, 1, 1440786600, 1),
(112, 95, 'Create Designation', 'designation/create', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(113, 111, 'Update Designation', 'designation/update', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(114, 111, 'Delete Designation', 'designation/delete', 0, 0, 0, '', 0, 1440786600, 1, 0, 0),
(115, 0, 'Settings', 'setting/index', 0, 1, 0, '', 0, 1440873000, 1, 1440873000, 1),
(116, 115, 'Create Setting', 'setting/create', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(117, 115, 'Update Setting', 'setting/update', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(118, 115, 'View Setting', 'setting/view', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(119, 0, 'News', 'news/index', 0, 1, 0, 'fa fa-newspaper-o', 0, 1440873000, 1, 0, 0),
(120, 119, 'Create News', 'news/create', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(121, 119, 'Update News', 'news/update', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(122, 119, 'View News', 'news/view', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(123, 119, 'Delete News', 'news/delete', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(124, 0, 'Volume-Issue', 'volume/index', 0, 1, 0, 'fa fa-align-right', 0, 1440873000, 1, 0, 0),
(125, 124, 'Create Volume-Issue', 'volume/create', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(126, 124, 'Update  Volume-Issue', 'volume/update', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(127, 124, 'View  Volume-Issue', 'volume/view', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(128, 124, 'Delete Volume-Issue', 'volume/delete', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(129, 0, 'Subscribers', 'subscriber/index', 0, 1, 0, 'fa fa-group', 0, 1440873000, 1, 0, 0),
(130, 129, 'Create Subscriber', 'subscriber/create', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(131, 0, 'Update Subscriber', 'subscriber/update', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(132, 0, 'Delete Subscriber', 'subscriber/delete', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(133, 0, 'View Subscriber', 'subscriber/view', 0, 0, 0, '', 0, 1440873000, 1, 0, 0),
(134, 0, 'Formatter', 'formatter/index', 0, 1, 0, 'fa fa-book', 0, 1442082600, 1, 0, 0),
(135, 134, 'Create Formatter', 'formatter/create', 0, 0, 0, '', 0, 1442082600, 1, 0, 0),
(136, 134, 'Update Formatter', 'formatter/update', 0, 0, 0, '', 0, 1442082600, 1, 0, 0),
(137, 134, 'View Formatter', 'formatter/view', 0, 0, 0, '', 0, 1442082600, 1, 0, 0),
(138, 134, 'Delete Formatter', 'formatter/delete', 0, 0, 0, '', 0, 1442082600, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_dt` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `status`, `created_dt`, `created_by`, `updated_dt`, `updated_by`, `is_deleted`) VALUES
(1, 'News For Authors:', '<p>We have started accepting articles by online means directly through website. Its our humble request to all the researchers to go and check the new method of article submission on below link: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a title="Submit-manuscript" href="../../../page/submitmenuscript">Submit online manuscript</a></p>\r\n<p>&nbsp;</p>', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1, 0),
(2, 'New Features:', '<p>Hello Researcher, we are happy to announce that now you can check the status of your paper right from the website instead of calling us. We would request you to go and check your paper status on the below link : <a href="../../frontend/page/contact-us">Click Here</a></p>', 0, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `qualification`
--

CREATE TABLE IF NOT EXISTS `qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `qualification`
--

INSERT INTO `qualification` (`id`, `name`, `status`, `is_deleted`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(1, 'Phd Completed', 1, 0, 1440863128, 1, 1440863196, 1),
(2, 'Phd Persuing', 1, 0, 1440863135, 1, 1440863200, 1),
(3, 'Me Completed', 1, 0, 1440863155, 1, 1440863155, 1),
(4, 'Me Persuing', 1, 0, 1440863162, 1, 1440863162, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE IF NOT EXISTS `role_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_title` varchar(128) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `created_dt` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `role_master`
--

INSERT INTO `role_master` (`id`, `role_title`, `is_deleted`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(1, 'Super Admin', 0, 1436878291, 1, 1436878291, 1),
(2, 'Drc Developer', 0, 1436878452, 1, 1436878452, 1),
(3, 'Admin', 0, 1437567434, 1, 1438587854, 1),
(4, 'Customer', 0, 1437649558, 1, 1437649558, 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(75) NOT NULL,
  `value` varchar(255) NOT NULL,
  `updated_dt` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`name`, `value`, `updated_dt`, `updated_by`) VALUES
('contact_address', 'test address', '0000-00-00 00:00:00', 1),
('contact_email', 'grdjournals@gmail.com', '0000-00-00 00:00:00', 1),
('contact_phone', '+91', '0000-00-00 00:00:00', 1),
('publisher', 'GRDJournals', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE IF NOT EXISTS `subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `subscriber`
--

INSERT INTO `subscriber` (`id`, `email`, `status`, `is_deleted`) VALUES
(1, 'pritesh966@gmail.com', 1, 0),
(2, 'test@test.com', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group` int(11) NOT NULL,
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `phone` varchar(50) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1= admin,2=merchant, 3=>customer',
  `profile_pic` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '''1:Yes'',''0:No''',
  `is_deleted` smallint(6) NOT NULL DEFAULT '0' COMMENT '''1:Yes'',''2:No''',
  `created_by` int(11) NOT NULL,
  `created_dt` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_group`, `first_name`, `last_name`, `email`, `password`, `phone`, `address`, `country_id`, `state_id`, `city_id`, `type`, `profile_pic`, `status`, `is_deleted`, `created_by`, `created_dt`, `updated_by`, `updated_dt`) VALUES
(1, 1, 'Journal', 'Admin', 'admin@admin.com', '127*132*143*141*148*89*92*95*78*80*82*84*86*88*90*92', '1234567890', 'India', 3586, 11, 1463, 1, '14-07-2015(JPEG Image, 300 × 168 pixels).jpeg', 1, 0, 0, 1436351250, 1, 1438692948);

-- --------------------------------------------------------

--
-- Table structure for table `vol_iss`
--

CREATE TABLE IF NOT EXISTS `vol_iss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `volume` tinyint(3) NOT NULL,
  `issue` tinyint(3) NOT NULL,
  `detail` varchar(50) NOT NULL,
  `last_date` date NOT NULL,
  `publish_date` date NOT NULL,
  `articles` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_dt` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_dt` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vol_iss`
--

INSERT INTO `vol_iss` (`id`, `volume`, `issue`, `detail`, `last_date`, `publish_date`, `articles`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `is_deleted`) VALUES
(1, 1, 1, 'September 2015', '2015-09-25', '2015-10-01', 0, 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
